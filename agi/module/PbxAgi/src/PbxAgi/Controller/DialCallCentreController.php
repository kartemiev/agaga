<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Service\ClientImpl\ClientImplInterface;
use PbxAgi\Operator\Model\OperatorTableInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Controller\DialControllerInterface as DialConstants;
use PbxAgi\DialDescriptor\DialOptionsDescriptor;

class DialCallCentreController extends AbstractActionController {
    protected $extensionTable;
    protected $operators;
    protected $que;
    protected $result;
    protected $operatorTableGateway;
    protected $agi;
    protected $appConfig;
    protected $isLocalChannelShortLived;
	protected $dialOptions;
    
    public function __construct(
            OperatorTableInterface $operatorTableGateway, 
            ClientImplInterface $agi,
            AppConfigInterface $appConfig,
    		DialOptionsDescriptor $dialOptions
            ) {
        $this->operatorTableGateway = $operatorTableGateway;
        $this->agi = $agi;
        $this->appConfig =  $appConfig;
        $this->dialOptions = $dialOptions;
    }

    public function indexAction() {
         $this->populateQue();
        $this->prepareDialParams();
        $this->run();
        return $this->result;
    }
    
      protected function populateQue()
    {
         $this->operators = $this->operatorTableGateway->fetchAll();
 
        while ($operator = $this->operators->current()) {
            $this->operators->next();
            $operatorFiltered = $operator->getArrayCopy();            
            if ($operatorFiltered['operatorstatus'] == AppConfigInterface::DB_OPERATOR_PRESENCE_STATE_LOGGEDIN)
            {
                $this->que[] = $operatorFiltered['extension'];
            }
        }
         
     }
     protected function prepareDialParams()
     { 
     	 $dialOptions = $this->dialOptions;
     	 $dialOptions->getIgnoreForwarding()->enable();
     	  
     	 $dialOptions->getRingingMoh()
     	 			 ->enable();
     	 $dialOptions->getIgnoreForwarding()
     	 			 ->enable();         
     }

     
     protected function getPostDilalStringSuffixOptions()
     {
         $postDilalStringOptions = '';
         $postDilalStringOptions.= ($this->isLocalChannelShortLived)? '':
                 DialConstants::PBX_DIAL_DIALCMD_KEEP_LOCAL_CHANNEL_UP_SUFFIX;
         return $postDilalStringOptions;
     }
     
     protected function run()
     {
        $dialString=array();
        $this->isLocalChannelShortLived = false;
//        $postDialStringOption = $this->getPostDilalStringSuffixOptions();
        $postDialStringOption = '/n';
        $dialSipExtensionContextName = $this->appConfig->getDialSipExtensionContextName();
        $dialDuration =  $this->appConfig->getDialCallCentreOperatorDuration();
         foreach ($this->que as $extension){
            $dialString[] = "Local/{$extension}@{$dialSipExtensionContextName}{$postDialStringOption}";
        }
        if (count($this->que)>0){           
            $this->result = $this->agi->dial(implode('&',$dialString), array(
                $dialDuration,
                $this->dialOptions->__toString()));
        }        
     }
     public function hangupAction()
     {     	
     }
 }
