<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Extension\Model\ExtensionTableInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Extension\Model\ExtensionInterface;
use PAGI\Exception\ChannelDownException;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\Entity\CallEntityInterface;
use PbxAgi\Service\AppConfig\AppConfigService;
use PbxAgi\CallDestination\Model\CallDestinationTable;
use PbxAgi\DialDescriptor\DialOptionsDescriptor;
use PbxAgi\Extension\Model\Extension;

class ExtensionReceiveIncomingController extends AbstractActionController {
    protected $agi;
    protected $extensionTable;
    protected $appConfig;
    protected $varManager;
    protected $call;
    protected $callDestinationTable;
    protected $diversionMap;
    protected $dialOptions;
    protected $extensionRecord;
    protected $duration;
    
    public function __construct(
             $agi, 
            ExtensionTableInterface $extensionTable,
            AppConfigInterface $appConfig,
            ChannelVarManagerInterface $varManager,
            CallEntityInterface $call,
    		CallDestinationTable $callDestinationTable,
    		DialOptionsDescriptor $dialOptionsDescriptor
            ) {
        $this->agi = $agi;
        $this->extensionTable = $extensionTable;        
        $this->appConfig = $appConfig;
        $this->varManager = $varManager;
        $this->call = $call;
        $this->callDestinationTable = $callDestinationTable;
        $this->dialOptions = $dialOptionsDescriptor;
    }     
        
    public function indexAction() {
        try {
        $extension = $this->agi->getVariable('EXTEN');        	 
        $this->init();
        $this->PrepareCallControllerPlugin()->setCallDestinator($extension);
         $extensionRecord =  $this->extensionTable->getExtension($extension);
         if ($extensionRecord)
        {
            $this->duration = $this->getDuration($extensionRecord);
            
        $callIsBlocked = $this->FeatureCheckPermissionPlugin('number_status',array('ACTIVE','UNDEFINED'),'CallDestinator');
        if (!$callIsBlocked)
        {
            return false;
        }
                
         $dialOptions = $this->dialOptions;
        
                 
        $callerTransferPermission = 
        $this->FeatureCheckPermissionPlugin('transfer',array('allowed','undefined'),'CallOwner');
        
        if ($callerTransferPermission){
        	$dialOptions->getAllowCallerTransfer()
        				->enable();
        }
        
        $calleeTransferPermission = $this->FeatureCheckPermissionPlugin('transfer',array('allowed','undefined'),'CallDestinator');
        
        if ($calleeTransferPermission){
        	$dialOptions->getAllowCalleeTransfer()
        				->enable();
        }
        
        if ($this->appConfig->getMohInternalState())
        {
          var_dump($this->call->getCallOwner()->getVpbxid());
		  $dialOptions->getRingingMoh()
					->enable()
					->setMohClass(
					    $this->appConfig
					         ->getGeneralSettings()->ringingtone.'_ringingtone'					         
					    );
        }
          
             $extensionType = $extensionRecord->getExtensiontype();
            
            if (AppConfigInterface::DB_INTERNAL_EXTENSIONTYPE_FAX == $extensionType)
            {
                $redirector = $this->RedirectorControllerPlugin();
                $result = $redirector
                    ->dispatch("/faxreceive/receive/{$extension}");                
                return $result;
            }
             
      
            
            if ($this->processUnconditionalDiversion($extensionRecord))
            {
                return;
            }
            
            $callDestinations = $this->callDestinationTable
            						 ->fetchAll( array('peerid'=> $extensionRecord->id) );
			$destinations = array();
            foreach ($callDestinations as $calldestination)
            {
                $destinations[] = $calldestination;
            }
            if (0==count($destinations))
            {    
            	$result = $this->processRegularCalling($extensionRecord);
            }
            else
            {
                $result = $this->processGroupCalling($extensionRecord, $destinations);
            }                                               
              $this->processDialResultStatuses($extensionRecord ,$result);
           } else 
        {
            $this->agi->hangup(1);
        }
        } catch (ChannelDownException $e) {            
        }        
    }
    
     
    public function hangupAction()
    {        
        $this->RecordCallPlugin()->updateCDR();   
     }
     protected function prepareChannelVars($call)
     {
         $this->varManager->setupOutgoingCall($call);
     }
     
     
     protected function processRegularCalling($extensionRecord)
     {
      	$technology = $this->getPeerTechnology($extensionRecord);
     	$name = $this->getPeerName($extensionRecord);
     	
     	$dialoptions = $this->dialOptions->__toString();     		 
     	$result = $this->agi->dial("{$technology}/{$name}", array($this->duration,$dialoptions));
     	return $result;     	    	
     }
     
     protected function processGroupCalling($extensionRecord, $destinations)
     {
      	
     	$dialOutContextName = $this->appConfig
     								->getVpbxDialoutContextName();

      
     	switch ($extensionRecord->callsequence)
     	{
     	    case AppConfigInterface::DB_CALLSEQUENCE_RECORDTYPE_SEQUENTIAL:
     	    	foreach ($destinations as $destination)
     	    	{
     	    		$result = ($extensionRecord->extension==$destination->number)? 
     	    		$this->processRegularCalling($extensionRecord):
     	    		$dialOptions = $this->dialOptions->__toString();
     	    		$result = $this->agi->dial("Local/{$destination->number}@{$dialOutContextName}", array($destination->duration, $dialOptions));
     	    		$dialStatus = $result->getDialStatus();
     	    		if (AppConfigInterface::ASTERISK_STATUS_ANSWER == $dialStatus)
     	    		{
     	    			break;
     	    		}     	    		
     	    	}
     	   	break;
     	    case AppConfigInterface::DB_CALLSEQUENCE_RECORDTYPE_SIMULRING:     	    	
     	    	$dialString = array();
     	    	$technology = $this->getPeerTechnology($extensionRecord);
     	    	$name = $this->getPeerName($extensionRecord);     	    		
     	    	foreach ($destinations as $destination)
     	    	{
     	    	    $dialString[] = ($extensionRecord->extension==$destination->number)
     	    	    ?
     	    	    "{$technology}/{$name}"
     	    	    		:
     	    	    "Local/{$destination->number}@{$dialOutContextName}";
     	    	}     	    		
     	    	$dialOptions = $this->dialOptions->__toString();
     	    	$result = $this->agi->dial(implode('&', $dialString), 
     	    			array($this->duration,$dialOptions)
     	    			);     	    		
     	    break;
     	}
     	return $result;
     }
     
     protected function processDialResultStatuses($extensionRecord, $result)
     {     	 
     	$dialStatus= $result->getDialStatus();
     	$diversionMap = $this->getDiversionMap();
     	if (isset($diversionMap[$dialStatus]))
     	{
     		$currentStatusMap = $diversionMap[$dialStatus];
     		$statusFieldName = $diversionMap[$dialStatus]['status_fieldname'];
     		if (AppConfigInterface::DB_DIVERSION_STATUS_ACTIVATED == $extensionRecord->$statusFieldName)
     		{     			 
        		$this->runDiversionAction($extensionRecord, $currentStatusMap);
     	   }
     	}
      }
     protected function getDiversionMap()
     {
     	if (!$this->diversionMap)
     	{
     		$this->diversionMap =     	
           array(
         		'UNCONDITIONAL' => array(
         				'landingtype_fieldname' => 'diversion_unconditional_landingtype',
         				'status_fieldname' => 'diversion_unconditional_status',
         				'children'=>array(
         				'NUMBER'=> array('callback'=>array($this,'divertNumber'),
         					'userdata'=>array(
         						'numberfield'=>'diversion_unconditional_number'
         							)
         						),
         				'VOICEMAIL'=> array('callback'=> array($this,'divertVoicemail')),
         				'FAX'=> array('callback'=>array($this,'divertFax'))
         					)
         		),         		 
         		AppConfigInterface::ASTERISK_STATUS_DIALSTATUS_NO_ANSWER => array(
         				'landingtype_fieldname' => 'diversion_noanswer_landingtype',
         				'status_fieldname' => 'diversion_noanswer_status',         				 
         				'children'=>array(
         				'NUMBER'=> array('callback'=>array($this,'divertNumber'), 
         						'userdata'=>array(
          								'numberfield'=> 'diversion_noanswer_number'
         							)         						
         						),
             			'VOICEMAIL'=> array('callback'=>array($this,'divertVoicemail')),
         				'FAX'=> array('callback'=>array($this,'divertFax'))
         						)
         			),
         		AppConfigInterface::ASTERISK_STATUS_DIALSTATUS_BUSY => array(
         				'landingtype_fieldname' => 'diversion_busy_landingtype',
         				'status_fieldname' => 'diversion_busy_status',         				 
         				'children'=>array(         						 
         				'NUMBER'=> array('callback'=>array($this,'divertNumber'),
         						'userdata'=>array(
          								'numberfield'=> 'diversion_busy_number'
         							)
         						),
         				'VOICEMAIL'=> array('callback'=>array($this,'divertVoiceMail')),
         				'FAX'=> array('callback'=>array($this,'divertFax'))
         						)
         		),
         		AppConfigInterface::ASTERISK_STATUS_DIALSTATUS_CHANUNAVAIL => array(
         				'landingtype_fieldname' => 'diversion_unavail_landingtype',
         				'status_fieldname' => 'diversion_unavail_status',
         				'children'=>array(
         				'NUMBER'=> array('callback'=>array($this,'divertNumber'),
         						'userdata'=>array(
          								'numberfield'=> 'diversion_unavail_number'
         							)
         						),
         				'VOICEMAIL'=> array('callback'=>array($this,'divertVoicemail')),
         				'FAX'=> array('callback'=>array($this,'divertFax'))
         		),
         				)
           );
     	}
     	return $this->diversionMap;
     }
     protected function processUnconditionalDiversion($extensionRecord)
     {
      	return  
     		(AppConfigInterface::DB_DIVERSION_STATUS_ACTIVATED == $extensionRecord->diversion_unconditional_status)
     		? 
     		call_user_func(function($extensionRecord) {
     			$diversionMap = $this->getDiversionMap();
     			$statusMap = $diversionMap['UNCONDITIONAL'];
     			$this->runDiversionAction($extensionRecord, $statusMap);
     			return true;     		 
     		},$extensionRecord) 
     		: false;
     }
     protected function runDiversionAction($extensionRecord, $statusMap)
     {
     	$statusFieldName = $statusMap['status_fieldname'];
        $landingtype = $extensionRecord->$statusMap['landingtype_fieldname'];
        $landingOptions = $statusMap['children'][$landingtype];        
        $callback = $landingOptions['callback'];             
        $userdata = (isset($landingOptions['userdata']))?$landingOptions['userdata']:null ;
        call_user_func($callback, $extensionRecord, $userdata); 
     }
     
     protected function divertFax($extensionRecord, $userdata = null)
     {
     	$redirector = $this->RedirectorControllerPlugin();
     	$result = $this->RedirectorControllerPlugin()
     	->dispatch("/faxreceive/receive/{$extensionRecord->extension}");
     	$this->agi->hangup();
     }
     protected function divertVoiceMail($extensionRecord, $userdata = null)
     {
     	$varManager = $this->varManager;
       	$varManager->voiceMail($extensionRecord->getMailbox()."@default");
      	$this->agi->hangup();
     }
     protected function divertNumber($extensionRecord, $userdata = null)
     {
     	$delay = 60;
     	$dialOutContextName = $this->appConfig->getVpbxDialoutContextName();
     	$numberfield = $userdata['numberfield'];
     	$forwardNum = $extensionRecord->$numberfield;
     	$dialOptions = $this->dialOptions->__toString();
     	$result = $this->agi
     				   ->dial("Local/{$forwardNum}@{$dialOutContextName}",array($delay,$dialOptions));
     	$this->agi->hangup();
     }
     public function getPeerName(ExtensionInterface $extensionRecord)
     {
     	return $extensionRecord->getName();
     }
     
     public function getPeerTechnology(ExtensionInterface $extensionRecord)
     {
 		return 'SIP';
     }
     protected function init()
     {
        $this->call = $this->PrepareCallControllerPlugin()
         		     	   ->initCall();
        $this->prepareChannelVars($this->call);
        
     //   $recordCallFeatureEnabled = $this->FeatureCheckPermissionPlugin('extensionrecord',array('active','undefined'),'CallDestinator');
        
       // if ($recordCallFeatureEnabled)
       // {
        // }         
        
      } 
      protected function getDuration(Extension $extensionRecord)
      {
      	$noanswerDiversionEnabled =
      	(AppConfigInterface::DB_DIVERSION_STATUS_ACTIVATED == $extensionRecord->diversion_noanswer_status);
      	$delay = ($noanswerDiversionEnabled)? $extensionRecord->diversion_noanswer_duration : null;
      	return $delay;
      }
      
}
