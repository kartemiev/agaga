<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Extension\Model\ExtensionTableInterface;
use PbxAgi\FaxSpool\Model\FaxSpool;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Exception\ChannelDownException;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\FaxSpool\Model\FaxSpoolTable;
use Zend\Mime\Mime;
use PbxAgi\Service\SendEmail\EmailMessage;

class FaxReceiveController extends AbstractActionController {
	const EMAIL_SUBJECT = "Получено факсимильное сообщение";
    protected $extensionTable;
    protected $agi;
    protected $appConfig;
    protected $varManager;
    protected $faxSpoolTable;
    protected $sendEmail;
    public function __construct(
    		ExtensionTableInterface $extensionTable,
    		FaxSpoolTable $faxSpoolTable,
    		ChannelVarManagerInterface $varManager,
    		AppConfigInterface $appConfig,
    		$agi
			) {
        $this->extensionTable = $extensionTable;
        $this->faxSpoolTable = $faxSpoolTable;
        $this->varManager = $varManager;
        $this->appConfig = $appConfig;
        $this->agi = $agi;       
    }
    
    public function receiveAction()
    {
        $agi = $this->agi;
        $appConfig = $this->appConfig;
        $varManager = $this->varManager;
        $uniqueid = $varManager->getUnqieId();
        $fax = new FaxSpool;
        $fax->setRecordtype(AppConfigInterface::DB_FAXSPOOL_RECORDTYPE_INCOMING);
        $fax->setUniqueid($uniqueid);        
        $faxSpoolTable = $this->faxSpoolTable;
        $lastid = $faxSpoolTable->saveFax($fax); /** creating db record about fax recieving 
                                                    attempt (referenced by the call's uniquid) **/
        
        
        
        $faxSpoolDir = $appConfig->getFaxReceiveSpoolDir();
        $faxPath = "{$faxSpoolDir}/{$lastid}.tiff"; 
        $faxReceiveOptions = $appConfig->getFaxReceiveOptions();                       
        $numTries = $appConfig->getFaxReceiveNumTries();
        $callerId = $varManager->getCallerId();
        $callerIdNumber = $callerId->getNumber();
        $callerIdName = $callerId->getName();
        
        $triesCount = 0;;
        try {
            $triesCount++;
            $agi->answer();
            $isChannelDown = false;            
            do {            
                $faxResult = $agi->faxReceive($faxPath); 
            } while ((!$faxResult->isSuccess())
                 && ($numTries <= $triesCount));           
         } catch (ChannelDownException $e)
        {                  
            
        }                
        $fax->faxstatus = $faxResult->getError();
        $fax->id = $lastid;
        
        if ($faxResult->isSuccess())
        {
                $this->sendFax2Email($faxPath,
                    array('cidName' => $callerIdName,
                        'cidNumber' => $callerIdNumber)
                    );
        }   
        $faxSpoolTable->saveFax($fax);
    }    

    protected function sendFax2Email($faxPath, $options)
    {
       $cidName = (isset($options['cidName']))?$options['cidName']:null;
       $cidNumber = (isset($options['cidNumber']))?$options['cidNumber']:null;
       $sendEmail = $this->getServiceLocator()
       					 ->get('PbxAgi\Service\SendEmail\SendEmail');
       
       $appConfig = $this->appConfig;
       $emailmessage = new EmailMessage();
       $emailmessage->exchangeArray(array(
                    'parameters'=>array(
                    		'cidName'=>$cidName,
                    		'cidNumber'=>$cidNumber
                     ),
       				'templatehtml' => 'mailTemplateHtml',
       				'templateplain' => 'mailTemplatePlain',
       				'layouthtml' => 'mailLayoutHtml',
       				'layoutplain' => 'mailLayoutPlain',       		 
       				'attachments' => array(
       							array('path'=>$faxPath, 'type'=>'image/tiff')),
       				'msgfromemail'=>$appConfig->getFaxReceiveMessageFromAddress(),
       				'msgfromfullname'=>$appConfig->getFaxReceiveMessageFromAddress(),
       				'msgto'=>$appConfig->getFaxReceiveMessageTo(),
       				'msgsubject'=>self::EMAIL_SUBJECT
       		)
       	);
        $sendEmail->send($emailmessage);            
    }
}
 