<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\Entity\CallEntityInterface;
use PbxAgi\Operator\Model\OperatorTableInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Client\IClient;
use PbxAgi\OperatorStatusLog\Model\OperatorStatusLogTableInterface;
use PbxAgi\OperatorStatusLog\Model\OperatorStatusLogInterface;
 
class OperatorPresenceFeatureController extends AbstractActionController {
    const ASTERISK_PAUSE_AFTER_COURTESY_TONE = 3;
    const ASTERISK_PAUSE_BEFORE_COURTESY_TONE = 1;    
    protected $varManager;
    protected $call;
    protected $operatorTable;
    protected $operator;
    protected $agi;
    protected $operatorStatusLogTable;
    protected $operatorStatusLog;
    protected $appConfig;
    public function __construct(
            ChannelVarManagerInterface $varManager, 
            CallEntityInterface $call, 
            OperatorTableInterface $operatorTable,
            IClient $agi,
            OperatorStatusLogTableInterface $operatorStatusLogTable,
            OperatorStatusLogInterface $operatorStatusLog,
            AppConfigInterface $appConfig
            ) {
        $this->varManager = $varManager;
        $this->call = $call;
        $this->operatorTable = $operatorTable;
        $this->agi = $agi;
        $this->operatorStatusLogTable = $operatorStatusLogTable;
        $this->operatorStatusLog = $operatorStatusLog;   
        $this->appConfig = $appConfig;
      }

    public function loginAction()
    {    
        $this->changeStatus(NULL, 
                AppConfigInterface::DB_OPERATOR_PRESENCE_STATE_LOGGEDIN,
                $this->appConfig->getOperatorChangeStatusLoginMedia()
                );
    }
    public function logoutAction()
    {
        $this->changeStatus(AppConfigInterface::DB_OPERATOR_PRESENCE_STATE_LOGGEDIN, 
                AppConfigInterface::DB_OPERATOR_PRESENCE_STATE_ABSENT,
                $this->appConfig->getOperatorChangeStatusLogoutMedia()
                );
        
    }
    public function lunchAction()
    {
             $this->changeStatus(AppConfigInterface::DB_OPERATOR_PRESENCE_STATE_LOGGEDIN, 
                AppConfigInterface::DB_OPERATOR_PRESENCE_STATE_LUNCH_AWAY,
                $this->appConfig->getOperatorChangeStatusLunchbreakMedia()     
                );
    }
    
    public function breakAction()
    {
             $this->changeStatus(AppConfigInterface::DB_OPERATOR_PRESENCE_STATE_LOGGEDIN, 
                AppConfigInterface::DB_OPERATOR_PRESENCE_STATE_SHORT_AWAY,
                     $this->appConfig->getOperatorChangeStatusShortbreakMedia()
                );
    }
    
    protected function changeStatus($oldStatus, $newStatus, $newStatusMedia)
    {
        $this->init();        
        $operator = $this->operator;
        $agi = $this->agi;
        
       $oldStatusFromTable = $operator->getOperatorstatus();
        
        if (($newStatus == $oldStatusFromTable) 
                || (($oldStatusFromTable !== $oldStatus) && (null !== $oldStatus)))
        {
            $agi->streamFile(
                    $this->appConfig->getOperatorChangeStatusIncorrectChoiceMedia()
                    );
        } else
        {
            $operator->setOperatorstatus( $newStatus );
            $this->operatorTable->saveOperator($operator);
            $this->logStatusChanges($newStatus);            
            $agi->streamFile($newStatusMedia);
         }  
         $agi->playBusyTone();
         sleep(self::ASTERISK_PAUSE_AFTER_COURTESY_TONE);
         $this->agi->hangup();       
    }
    
    protected function logStatusChanges($newStatus)
    {
        $extensionNum = $this->call->getCallOriginator()->getExtension();
            $operatorStatusLog = $this->operatorStatusLog;
            $operatorStatusLog->setExtension($extensionNum);
            $operatorStatusLog->setOperatorstatus($newStatus);
            $this->operatorStatusLogTable
                ->addEntry($operatorStatusLog); 
    }

    protected function init()
    {
        $agi = $this->agi;
        $agi->answer();
        sleep(self::ASTERISK_PAUSE_BEFORE_COURTESY_TONE);
        $this->call = $this
                ->PrepareCallControllerPlugin()
                ->initCall();
        $this->prepareChannelVars($this->call);     
        
         $extenNum = $this->call
                ->getCallOriginator()
                ->getExtension();
        $operator = $this->operatorTable->getOperator($extenNum);
        $this->operator = ($operator)? $operator : null;
        
    }       
       protected function prepareChannelVars($call)
    {
        $this->varManager->setupOutgoingCall($call);
    }
}
 