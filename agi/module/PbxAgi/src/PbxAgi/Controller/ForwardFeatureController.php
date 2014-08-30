<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PAGI\Exception\ChannelDownException;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Client\IClient;
use PbxAgi\Extension\Model\ExtensionTableInterface;
use PbxAgi\Entity\CallEntityInterface; 

class ForwardFeatureController extends AbstractActionController {
    
     protected $extensionTableGateway;
     protected $appconfig;
     protected $agi;
     protected $callEntity;
     protected $originator;     
                 
     public function __construct (
      ExtensionTableInterface $extensionTableGateway,
              AppConfigInterface $appConfig, 
           IClient $agi,
           CallEntityInterface $callEntity
             ) {
        $this->extensionTableGateway = $extensionTableGateway;
        $this->appconfig = $appConfig;
        $this->agi = $agi;
        $this->callEntity = $callEntity;        
        $this->originator = 
                $this->callEntity->
                getCallOriginator();        
        $agi->answer();
        sleep(1);
       }

      
    public function activateAction()
    {   
        
        /*
         * 
         * !TODO: При изначальной установке переадресации не проговаривается номер на который устанавливается переадресация
         * от Андрея Гранковского
         * 
         */
        $agi = $this->agi;            
        $currentForwardState = $this->originator->diversion_unconditional_status;
        $currentForwardNum = $this->originator->diversion_unconditional_number;
        if (AppConfigInterface::DB_DIVERSION_STATUS_ACTIVATED !== $currentForwardState)
        {
            $agi->playCongestionTone();
            $extensionNum = $this->originator->getExtension();
            $extensionTableGateway = $this->extensionTableGateway;
            $extension = $extensionTableGateway->getExtension($extensionNum);
            $extension->diversion_unconditional_status =  AppConfigInterface::DB_DIVERSION_STATUS_ACTIVATED;
            $extensionTableGateway->updateExtensionUnconditionalForward($extension);
         }
  
         $agi->streamFile(
        		  $this->appconfig->getCallForwardMediaDiversionReenabledNumNotice()
                );
        $this->sayNumber($currentForwardNum);
        
        sleep(3);
        $agi->hangup();
    }
    
    public function deactivateAction()
    {
        $agi = $this->agi;
        $currentForwardState = $this->originator->diversion_unconditional_status;        
        if (AppConfigInterface::DB_DIVERSION_STATUS_ACTIVATED == $currentForwardState)
        {
            $extensionNum = $this->originator->getExtension();
            $extensionTableGateway = $this->extensionTableGateway;
            $extension = $extensionTableGateway->getExtension($extensionNum);
            $extension->diversion_unconditional_status = AppConfigInterface::DB_DIVERSION_STATUS_DEACTIVATED;
            $extensionTableGateway->updateExtensionUnconditionalForward($extension);
            $agi->streamFile(
                $this->appconfig->getCallForwardMediaDiversionCleared()
                );
         }
         else
        {            
            $agi->playBusyTone();
        }        
        sleep(3);
        $agi->hangup();        
    }
    
    
    public function setnumAction()
    {
        $agi = $this->agi;
        $dialedNumber = $this->callEntity->getExten();
        $setnumCombination = $this->appconfig->getCallForwardNumCombination();
        $forwardDestinationNum = substr( $dialedNumber, strlen($setnumCombination));
        if (strlen($forwardDestinationNum)>2)
        {
            $extensionNum = $this->originator->getExtension();
            $extensionTableGateway = $this->extensionTableGateway;
            $extension = $extensionTableGateway->getExtension($extensionNum);            
            $extension->diversion_unconditional_number = $forwardDestinationNum;
            $extension->diversion_unconditional_status = AppConfigInterface::DB_DIVERSION_STATUS_ACTIVATED;
            $extension = $extensionTableGateway->updateExtensionUnconditionalForward($extension);
                $agi->streamFile(
                $this->appconfig->getCallForwardMediaDiversionHasBeenSetup()
                );        
        }
        else
        {
            $agi->playBusyTone();
        }
               sleep(3);
        $agi->hangup();        
    }
     
    public function checkAction()
    {
        $agi = $this->agi;
        $forwardNum = $this->originator->diversion_unconditional_number;
        $this->sayNumber($forwardNum);
         $currentForwardState = $this->originator->diversion_unconditional_status;
         switch ($currentForwardState) {
             case AppConfigInterface::DB_DIVERSION_STATUS_ACTIVATED:
                 $agi->streamFile( $this->appconfig->getCallForwardMediaDiversionHasBeenSetup() );
                 break;
             case AppConfigInterface::DB_DIVERSION_STATUS_DEACTIVATED:
                 $agi->streamFile( $this->appconfig->getCallForwardMediaDiversionCleared());
                 break;
             default:                 
                 break;
         }
            sleep(3);
            $agi->hangup();            
     }
     protected function sayNumber($forwardNum)
     {
         $agi = $this->agi;
         $extensionLength = $this->appconfig->getExtensionLength();
         switch (strlen($forwardNum)) {
             case ($extensionLength):
                 $agi->sayNumber($forwardNum);
                 break;
             case AppConfigInterface::EXTENSION_NUMBER_LENGTH_LOCAL:
                 $prefixCode = substr($forwardNum,0,3);
                 $firstPart = substr($forwardNum,3,2);
                 $secondPart = substr($forwardNum,5,2);
                 $agi->sayNumber($prefixCode);
                 $agi->sayNumber($firstPart);
                 $agi->sayNumber($secondPart);
                 break;
             case AppConfigInterface::EXTENSION_NUMBER_LENGTH_10_DIGITS:
                 $defCode = substr($forwardNum,0,3);
                 $prefixCode = substr($forwardNum,3,3);
                 $firstPart = substr($forwardNum,6,2);
                 $secondPart = substr($forwardNum,8,2);
                 $agi->sayDigits($defCode);
                 $agi->sayNumber($prefixCode);
                 $agi->sayNumber($firstPart);
                 $agi->sayNumber($secondPart);
                 break;
             case AppConfigInterface::EXTENSION_NUMBER_LENGTH_11_DIGITS:
                 $gatewayCode = ( in_array(substr($forwardNum,1,1), array('7','8')) ) ?
                 substr($forwardNum,1,1) : null;
                 if ($gatewayCode)
                 {
                     $defCode = substr($forwardNum,0,3);
                     $prefixCode = substr($forwardNum,3,3);
                     $firstPart = substr($forwardNum,6,2);
                     $secondPart = substr($forwardNum,8,2);
                     $agi->sayDigits($gatewayCode);
                     $agi->sayDigits($defCode);
                     $agi->sayNumber($prefixCode);
                     $agi->sayNumber($firstPart);
                     $agi->sayNumber($secondPart);
                 }
                 else
                 {
                     $agi->sayDigits($forwardNum);
                 }
                 break;
             default:
                 break;
         }
     }    
}
