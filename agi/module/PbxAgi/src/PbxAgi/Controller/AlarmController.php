<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\ValidatorInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Node\Node;
use PAGI\CallSpool\CallFile;
use PbxAgi\Service\DialString\SimpleTimeParser;
use PbxAgi\Service\CallSpoolImpl\CallSpoolImplFactory;
use PbxAgi\DialDescriptor\LocalDialDescriptor;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;

class AlarmController extends AbstractActionController
{
    public $callSpoolImpl;
    public $agi;
    public $simpleTimeWithoutSemicolumnValidator;
    public $appConfig;
    public $simpleTimeParser;
    public $dateTime;
    public $varManager;
	public function __construct(
	    CallSpoolImplFactory $callSpoolImpl, 
	    $agi, 
	    ValidatorInterface $simpleTimeWithoutSemicolumnValidator, 
	    AppConfigInterface $appConfig,
	    SimpleTimeParser $simpleTimeParser,
	    \DateTime $dateTime,
	    ChannelVarManagerInterface $varManager
    )
	{
		$this->callSpoolImpl = $callSpoolImpl;
		$this->agi = $agi;
		$this->simpleTimeWithoutSemicolumnValidator = $simpleTimeWithoutSemicolumnValidator;
		$this->appConfig = $appConfig;
		$this->simpleTimeParser = $simpleTimeParser;
		$this->dateTime = $dateTime;
		$this->varManager = $varManager;
	}
	public function setAction()
	{

	    $exten = $this->varManager->getExten();
	    preg_match('/^\*\d\d\*([0-9]+)$/', $exten, $matches);
	    $scheduletime = $matches[1];
 	    $agi = $this->agi;
	    $appConfig = $this->appConfig;
	    $agi->answer();
	    if (!$this->simpleTimeWithoutSemicolumnValidator->isValid($scheduletime))
	    {
            $agi->streamFile('silence/1'); 
	    	$agi->streamFile($appConfig->getAlarmWrongTimeFormat());
            $agi->streamFile('silence/1'); 	    	
	    }
	    else 
	    {
	        $call = $this->PrepareCallControllerPlugin()
	                     ->initCall();
	        $this->call = $call;
	        
	        $extension = $call->getCallOriginator()->getExtension();
	        
	        $simpleTimeParser = $this->simpleTimeParser;
	        $dateTimeSchedule = $simpleTimeParser($scheduletime);
	        if (!($dateTimeSchedule instanceof \DateTime))
	        {
	        	throw new \Exception('Error parsing date - unexpected error, should not have happened!');
	        }
	        $dateTimeScheduleCurrent = $this->dateTime;
	        if ($dateTimeSchedule<$dateTimeScheduleCurrent)
	        {
	            $intervalOneDay = new \DateInterval('P1D');	            
	            $dateTimeSchedule->add($intervalOneDay);
	        }
	        
 	        $dialDescriptor = new LocalDialDescriptor($extension, $appConfig->getDialSipExtensionContextName());
	        $callFile = new CallFile($dialDescriptor);
	        $callFile->setContext($appConfig->getAlarmPlayContextName());
	        $callFile->setExtension($extension);
	        $callFile->setPriority(1);
	        $callFile->setMaxRetries(3);
	        $callFile->setWaitTime(60);
	        $spool = $this->callSpoolImpl->getInstance(
	        		array(
	        				'tmpDir' => $appConfig->getTmpDir(),
	        				'spoolDir' => $appConfig->getAsteriskCallfileSpoolPath()
	        		)
	        );
	        $spool->spool($callFile, $dateTimeSchedule->getTimestamp());
	    }
	    $agi->hangup();
	}
	 
}