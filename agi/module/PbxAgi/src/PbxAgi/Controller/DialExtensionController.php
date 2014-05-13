<?php
namespace PbxAgi\Controller;;

use PbxAgi\Extension\Model\ExtensionTableInterface;
use PbxAgi\Service\ClientImpl\ClientImplInterface;
use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Extension\Model\ExtensionValidatorInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Service\AppConfig\AppConfigService;
use PbxAgi\DialDescriptor\DialOptionsDescriptor;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\Entity\CallEntityInterface;
use PbxAgi\Entity\CallDestinatorEntity;
use PbxAgi\Extension\Model\Extension;

class DialExtensionController extends AbstractActionController {
    protected $extensionTable;
    protected $agi;
    protected $extensionValidator;
    protected $appConfig;
    protected $varManager;
    protected $isCallTransfered;
    protected $dialOptionsDescriptor;
    protected $call;
    public function __construct(
            ExtensionTableInterface $extensionTable, 
             $agi,
            ExtensionValidatorInterface $extensionValidator,
            AppConfigInterface $appConfig,
    		DialOptionsDescriptor $dialOptionsDescriptor,
    	    ChannelVarManagerInterface $varManager,
            CallEntityInterface $call
            ) {
        $this->extensionTable = $extensionTable;
        $this->agi = $agi;
        $this->extensionValidator = $extensionValidator; 
        $this->appConfig = $appConfig;
        $this->dialOptionsDescriptor = $dialOptionsDescriptor;
        $this->varManager = $varManager;
        $this->call = $call;
    }
     
    protected function callExtension($extension)
    {         
        $this->prepareCall($extension);
        
           $dialoptions = $this->dialOptionsDescriptor;         
         $this->setupBasicDialOptions();                  
          $callerTransferPermission = $this->varManager
                						  ->getCallerTransferPermission();         
         $this->isCallTransfered = $this->varManager->isTransfered();
         
         if ($callerTransferPermission){
             $dialoptions->getAllowCallerTransfer()
             			 ->enable();
         }
        
         $recordCallFeatureEnabled = $this->FeatureCheckPermissionPlugin('extensionrecord',array('active','undefined'),'CallDestinator');

         $varManager = $this->varManager;
         /* 
          * don't record call if call recording is disabled for the originator
          * only record call if call recording is enabled for both or call comes from PSTN
          */
         if ($recordCallFeatureEnabled && (!$varManager->isRecordingForbidden()))
         {
         	$dialoptions->getExecuteMacro()
         	            ->enable()
         	             ->setMacroName('callrecord');
         	$this->varManager->setupRecordFilename();         	
         }   
         
      $releaseChannel = $this->getDialReleaseChannelWhenDial();  
      $result = $this->agi->dial('Local/'.
              $extension."@".
                  $this->appConfig->getExtensionSipReceiveIncomingContextName().'/n',
               array(60,$dialoptions.'g')
              );
      
    }
 
    public function indexAction()
    {
        $extension = $this->agi->getVariable('EXTEN');
        $extensionIsValid = $this->extensionValidator->isValid($extension);     
        return ($extensionIsValid)?$this->callExtension($extension):false; 
    }
    public function hangupAction()
    {
          
    }
   
    protected function getDialReleaseChannelWhenDial()
    {
        return $this->isCallTransfered;
    }
    protected function setupBasicDialOptions()
    {
    	$dialoptions = $this->dialOptionsDescriptor;
    	$dialoptions->getAllowCalleeTransfer()
    				->enable();
    	if ($this->appConfig->getMohInternalState())
    	{
    	   $dialoptions->getRingingMoh()
    				   ->enable();
    	}
    }
    protected function prepareCall($extension)
    {
        $extensionRecord = $this->extensionTable->getExtension($extension);
        $call = $this->call;
        $destinatorEntity = new CallDestinatorEntity();
        $destinatorEntity->exchangeArray($extensionRecord->getArrayCopy());
        $call->setCallDestinator($destinatorEntity);        
    }
  }