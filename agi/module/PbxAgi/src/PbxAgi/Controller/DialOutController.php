<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PAGI\Exception\ChannelDownException;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Client\IClient;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\ShortDial\Model\ShortDialTable;
use PbxAgi\Extension\Model\Extension;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class DialOutController extends AbstractActionController
{
    protected $appConfig;
    protected $clientImpl;
    protected $call;
    protected $exten;
    protected $varManager;
    protected $redirector;
    protected $agi;
    protected $shortDialTable;
    public function __construct (
           AppConfigInterface $appConfig, 
           IClient $agi, 
            ChannelVarManagerInterface $varManager,
        ShortDialTable $shortDialTable
             ) {
        $this->appConfig = $appConfig;
        $this->agi = $agi;        
        $this->varManager = $varManager;
        $this->shortDialTable = $shortDialTable;
      }   
    public function indexAction()
    {
        try {                            
         $this->init();
          $this->varManager->setCallerTransferPermission(true);
         $this->varManager->initTransferContext();
         $this->TransferControllerPlugin();  
         
         $extension = $this->call->getExten();
        $extensiontype = $this->call->getCallOwner()->getExtensionType();
         
        $extensionRecord = new Extension();
        
        $hydrator = new ClassMethodsHydrator(false);        
        $data = $hydrator->extract($this->call->getCallOwner());        
		$hydrator->hydrate($data, $extensionRecord);        						 
	 
		$recordCallFeatureEnabled = $this->FeatureCheckPermissionPlugin('extensionrecord',array('active','undefined'),'CallOwner');
		
		if (!$recordCallFeatureEnabled)
		{
		    $this->varManager->setRecordingForbidden();
		}
		 
		
        if ($this->checkIsOriginatorBlocked($extensionRecord))         
       	{
        
        	$this->processShortDialFeature($extension);
        
        	$redirector = $this->redirector;
        	$destination = "/dialout/{$extensiontype}/{$extension}";
      
        	$this->setCallerIdNum();
        
       		$result = $redirector->dispatch($destination
                );
        	if (!$result)
        	{
            	$this->handleWrongNumDialed();
        	}
        }
         } catch (ChannelDownException $e) 
        {
            
        }
    }
         
    protected function prepareChannelVars($call)
    {
        $this->varManager->setupOutgoingCall($call);
    }
 
    protected function init()
    {
        $this->redirector = $this->RedirectorControllerPlugin();
        
        $this->call = $this
                ->PrepareCallControllerPlugin()                                
                ->initCall();   
          $this->prepareChannelVars($this->call);
    }       
    public function hangupAction()
    {
       $this->RecordCallPlugin()->updateCDR();
    }
    protected function setCallerIdNum()
    {
        $call = $this->call;
        $extension = $call->getCallOriginator()
                    ->getExtension();
        $this->agi->getCallerId()->setNumber((string)$extension);
 //       $this->agi->setCallerId((string)$extension,(string)$extension);     
     }
     public function handleWrongNumDialed()
     {
         $agi = $this->agi;
         sleep(1);
         $agi->exec('Playback',array($this->appConfig->getInvalidNumberDialedMessage()));
         sleep(1);
         $agi->exec('Playback',array($this->appConfig->getInvalidNumberDialedMessage()));
         sleep(1);
         $agi->playBusyTone();
         sleep(1);
         $agi->hangup(3);          
     }   
     protected function processShortDialFeature(&$exten)
     {
         $peerId = $this->call->getCallOwner()->getId();
         $shortDialTable = $this->shortDialTable;
         $shortDial = $shortDialTable->getShortDialByShort($exten, $peerId);
         if ($shortDial->count()>0)
         {
             $exten = $shortDial->current()->number;
         }
     }
     protected function checkIsOriginatorBlocked($extensionRecord)
     {
     	$result = true;
     	
     	$callerNumberStatusPermission = $this->FeatureCheckPermissionPlugin('number_status',array('ACTIVE','UNDEFINED'));
     	if (!$callerNumberStatusPermission)
     	{
     		$agi = $this->agi;
     		for ($repeatCount = 1; $repeatCount<=2;$repeatCount++)
     		{
     			sleep(1);
     			$agi->exec('Playback',array($this->appConfig->getNumberIsBlockedMedia()));
     		}
     		sleep(1);
     		$agi->playBusyTone();
     		sleep(1);
     		$agi->hangup(3);
     		$result = false;
     	}
     	return $result;     	    	
     }
}
