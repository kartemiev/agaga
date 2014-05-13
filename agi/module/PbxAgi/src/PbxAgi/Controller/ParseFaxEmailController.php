<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail\Message as MailMessage;
use PAGI\CallSpool\CallFile;
use PAGI\CallSpool\Impl\CallSpoolImpl;
use PbxAgi\DialDescriptor\LocalDialDescriptor;
use PbxAgi\Service\SendEmail\SendEmailInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\FaxSpool\Model\FaxSpoolTableInterface;
use PbxAgi\FaxSpool\Model\FaxSpool;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLog;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTableInterface;
use Zend\Mime\Mime;
use Zend\Mime\Decode;
use Zend\Mime\Message as MimeMessage;
use PbxAgi\Entity\IncomingMessage;
use PbxAgi\Service\Reader\ReaderInterface;
use PbxAgi\Service\Writer\WriterInterface;
use PbxAgi\Service\Executer\ExecuterInterface;
use PbxAgi\Service\CallSpoolImpl\CallSpoolImplFactory; 
use PbxAgi\Service\SendEmail\EmailMessage;
use Zend\Validator\ValidatorInterface;
use PbxAgi\Service\FaxParse\FaxRetrieveAttachment;
use PbxAgi\Service\FaxParse\FaxRetrieveSender;

class ParseFaxEmailController extends AbstractActionController
{
	protected $sendEmail;
	protected $appConfig;
	protected $faxSpoolTable;
	protected $faxSpoolLogTable;
	protected $spoolId;
	protected $senderFromAddress;
	protected $reader;
	protected $writer;
	protected $executer;
	protected $callSpoolImpl;
	protected $faxSenderValidator;
	protected $faxAttachmentFormatValidator;
	protected $faxRetrieveAttachment;
	protected $faxRetrieveSender;
	protected $faxAttachmentPresentValidator;
	const AUTH_ACTION = 'FAX_OUTGOING_AUTH';
	
 	public function __construct(
			SendEmailInterface $sendEmail, 
			AppConfigInterface $appConfig,
 			FaxSpoolTableInterface $faxSpoolTable,
 			FaxSpoolLogTableInterface $faxSpoolLogTable,
 			ReaderInterface $reader,
 			WriterInterface $writer,
 			ExecuterInterface $executer,
 		    CallSpoolImplFactory $callSpoolImpl,
 	        ValidatorInterface $faxSenderValidator,
   	        ValidatorInterface $faxAttachmentFormatValidator,
 	        FaxRetrieveAttachment $faxRetrieveAttachment,
 	        FaxRetrieveSender $faxRetrieveSender,
 	        ValidatorInterface $faxAttachmentPresentValidator 	    
		)
	{
		$this->sendEmail = $sendEmail;
		$this->appConfig = $appConfig;
		$this->faxSpoolTable = $faxSpoolTable;
		$this->faxSpoolLogTable = $faxSpoolLogTable;
		$this->reader = $reader;
		$this->writer = $writer;
		$this->executer = $executer;
		$this->callSpoolImpl = $callSpoolImpl;
		$this->faxSenderValidator = $faxSenderValidator;
		$this->faxAttachmentFormatValidator = $faxAttachmentFormatValidator;
		$this->faxRetrieveAttachment = $faxRetrieveAttachment;
		$this->faxRetrieveSender = $faxRetrieveSender;
		$this->faxAttachmentPresentValidator = $faxAttachmentPresentValidator;
	}
    public function indexAction()
    {
     	$messageText = $this->reader
     				->getReadedValue(); 
      	
     	$msg = MailMessage::fromString($messageText);
     	
     	$incomingMessage = new IncomingMessage();
     	$incomingMessage->create($msg);
     	
     	
		if ($this->init($incomingMessage)){
			$this->enqueueOutgoingFax($incomingMessage);		 
		}		 		
    }
    
    public function init($incomingMessage)
    {
    	$this->spoolId = $this->createQueueRecord();    	 
    	$actionresult = $this->checkSpoolMessageIntegrity($incomingMessage);
    	$this->createLogEntryRecord($this->spoolId, $actionresult);
    	return $actionresult;
    }
 
    protected function createQueueRecord()
    {
    	$faxSpool = new FaxSpool();    	 
     	$spoolId = $this->faxSpoolTable->saveFax($faxSpool);    	 
    	return $spoolId;
    }
    
    protected function createLogEntryRecord($spoolId, $actionresult)
    {
    	$faxSpoolLog = new FaxSpoolLog();
    	 
    	$faxSpoolLogEntry = array(
    			'spoolref' => $spoolId,
    			'action' => self::AUTH_ACTION,
    			'result'=> $actionresult
    	);
    	 
    	$this->faxSpoolLogTable->saveLogEntry($faxSpoolLog);
    }
    
     
    protected function checkFaxUser($email)
    {
        $faxuser =  $this->faxUserTable->getFaxUserByEmail($email);
        $faxuser = (isset($faxuser))?$faxuser:null;
        return $faxuser;
    }
    
    protected function getCheckIntegrityMap()
    {
        return array(
        		array(
        		'callback'=>'checkSenderAuth',
        		'failurecode'=>'SENDERUNAUTHORZIED'
        ),
        		array(
        				'callback'=>'checkAttachmentPresent',
        				'failurecode'=>'ATTACHMENTEMPTY'
        		),
        		array(
        				'callback'=>'checkAttachmentFormat',
        				'failurecode'=>'INVALIDFAXFORMAT'
        		),
        		
        );
    }
    
    protected function checkSpoolMessageIntegrity($incomingMessage)
    {
    	$result = true;     
    	$integritymap = $this->getCheckIntegrityMap();
     
    	foreach ($integritymap as $entry)
    	{
     		$isFailed = call_user_func(array($this,$entry['callback']),$incomingMessage);
    		if ($isFailed)
    		{
    			$result = $entry['failurecode'];
    			break;
    		}
    	}
    	return !$isFailed;
    }
    
    public function checkSenderAuth($incomingMessage)
    {
    	$isAuthorized = $this->faxSenderValidator->isValid($incomingMessage);  
    	if (!$isAuthorized)
    	{
    		$this->bounceUnauthorizedSender($incomingMessage);    		
    	}
    	return $isAuthorized;
    }
    public function checkAttachmentPresent($incomingMessage)
    {
      return $this->faxAttachmentPresentValidator->isValid($incomingMessage); 
    }

    public function checkAttachmentFormat($incomingMessage)
    {   
    	return $this->faxAttachmentFormatValidator->isValid($incomingMessage);
    }
    
    
    protected function bounceUnauthorizedSender($msg)
    {
    	$sendEmail = $this->sendEmail;
    	$appConfig = $this->appConfig;
    	$emailmessage = new EmailMessage();
    	    	     	
    	$msgToEmail =  $this->faxRetrieveSender->getSender($msg);
    	 
     	$emailmessage->exchangeArray(array(
    			'parameters'=>array(
    					'cidName'=>$cidName,
    					'cidNumber'=>$cidNumber
    			),
    			'templatehtml' => 'mailTemplateHtml',
    			'templateplain' => 'mailTemplatePlain',
    			'layouthtml' => 'unaunthorizedSenderBounceLayoutHtml',
    			'layoutplain' => 'unaunthorizedSenderBounceLayoutPlain',
    			'msgfromemail'=>$appConfig->getFaxReceiveMessageFromAddress(),
    			'msgfromfullname'=>$appConfig->getFaxReceiveMessageFromAddress(),
    			'msgto' => $msgToEmail,
    			'msgsubject'=>$appConfig->getEmailfaxBounceUnknownUserSubject()
    			)
    	);
    	$sendEmail->send($emailmessage);
    }
    protected function bounceProperAttachmentMissing($msg)
    {
    	$sendEmail = $this->sendEmail;
    	$appConfig = $this->appConfig;
    	$emailmessage = new EmailMessage();
    	 
    	$to = null;
    	foreach ($msg->getHeaders() as $plugin)
    	{
    		if ($plugin instanceof \Zend\Mail\Header\To)
    		{
    			$to = $plugin;
    		}
    	}
    	 
    	$msgToEmail =  $this->faxRetrieveSender->getSender($msg);
    	
    	$emailmessage->exchangeArray(array(
    			'parameters'=>array(
    					'cidName' => $cidName,
    					'cidNumber' => $cidNumber
    			),
    			'templatehtml' => 'mailTemplateHtml',
    			'templateplain' => 'mailTemplatePlain',
    			'layouthtml' => 'unaunthorizedSenderBounceLayoutHtml',
    			'layoutplain' => 'unaunthorizedSenderBounceLayoutPlain',
    			'msgfromemail'=>$appConfig->getFaxReceiveMessageFromAddress(),
    			'msgfromfullname'=>$appConfig->getFaxReceiveMessageFromAddress(),
    			'msgto' => $msgToEmail,
    			'msgsubject'=>$appConfig->getEmailfaxBounceUnknownUserSubject()
    	)
    	);
    	$sendEmail->send($emailmessage);    	 
    }
     
    protected function persistFaxAttachment($incomingMessage)
    {
        
    	$faxAttachmentPart = $this->faxRetrieveAttachment->getFaxAttachment($incomingMessage);
        if ($faxAttachmentPart)
        {    	
        	$faxAttachmentContent = $faxAttachmentPart['content'];
        	$tmpName = $this->appConfig->getTmpDir().'/tempFaxContent'.$this->spoolId;
        	$this->writer->writeStream($tmpName, $faxAttachmentContent);
        }
        return ($faxAttachmentPart)?$tmpName:null;
    }
    
    protected function convertFaxFile($path)
    {
    	$appConfig = $this->appConfig;
    	$faxSpoolPath = $appConfig->getFaxSpoolPath().'/'.$this->spoolId.'.tiff';
    	$gsBin = $appConfig->getGhostscriptBinaryPath();
    	$this->executer->exec("{$gsBin} -q -sDEVICE=tiffg3 -r204x196 -dBATCH -dPDFFitPage -dNOPAUSE -sOutputFile=\"{$faxSpoolPath}\" \"{$path}\"");    	 
    	return $faxSpoolPath;
    }
    protected function enqueueOutgoingFax($incomingMessage)
    {    	 
    	$tmpFileName = $this->persistFaxAttachment($incomingMessage);   	
    	$tiffFileName = $this->convertFaxFile($tmpFileName);
     	$appConfig = $this->appConfig;    	
    	$dialDescriptor = new LocalDialDescriptor($extension, $appConfig->getFaxdialerContextName());    	
    	$callFile = new CallFile($dialDescriptor);
    	$callFile->setContext($appConfig->getFaxsenderContextName());
    	$callFile->setExtension($extension);
    	$callFile->setVariable('FILENAME', $tiffFileName);
    	$callFile->setVariable('SPOOLID', $this->spoolId);
    	$callFile->setPriority('1');
    	$callFile->setMaxRetries($appConfig->getFaxSendMaxTries());
    	$callFile->setWaitTime($appConfig->getFaxSendWaitTime());     	
    	$spool = $this->callSpoolImpl->getInstance(
    			array(
    					'tmpDir' => $appConfig->getTmpDir(),
    					'spoolDir' => $appConfig->getAsteriskCallfileSpoolPath()
    			)
    	);
    	$spool->spool($callFile, time() + 10);    	
    }       
}