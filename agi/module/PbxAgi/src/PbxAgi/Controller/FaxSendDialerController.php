<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\FaxSpool\Model\FaxSpool;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLog;
use PAGI\Exception\ChannelDownException;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\FaxSpool\Model\FaxSpoolTableInterface;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTableInterface;
use PbxAgi\DialDescriptor\LocalDialDescriptor;

class FaxSendDialerController extends AbstractActionController
{
	public $varManager;
	public $appConfig;
	public $agi;
	public $faxSpoolTable;
	public $faxSpoolLogTable;
	
	public function __construct(
			ChannelVarManagerInterface $varManager,
			AppConfigInterface $appConfig,
			$agi,
			FaxSpoolTableInterface $faxSpoolTable,
			FaxSpoolLogTableInterface $faxSpoolLogTable
	) {
		$this->varManager = $varManager;
		$this->appConfig = $appConfig;
		$this->agi = $agi;
		$this->faxSpoolTable = $faxSpoolTable;
		$this->faxSpoolLogTable = $faxSpoolLogTable;
	}
   public function indexAction()
   {   	
		$faxSpoolLogId = $this->logDialingAttempt();   		
		$result = $this->dialFaxNum();
        $this->updateDialingAttemptLog($faxSpoolLogId, $result);        
   }
   protected function logDialingAttempt()
   {
    	$faxSpoolTable = $this->faxSpoolTable;
    	$agi = $this->agi;
   		$spoolId = $agi->getVariable('SPOOLID');
   		$faxSpool = new FaxSpool();
   		$faxSpool->id = $spoolId;
   		$faxSpool->uniqueid = $this->varManager->getUnqieId();
   		$faxSpool->faxstatus = 'DIALING';
   		$faxSpoolTable->saveFax($faxSpool);
   	
   		$faxSpoolLog = new FaxSpoolLog();
   	
   		$faxSpoolLog->exchangeArray(
   			array(
   					'spoolref' => $spoolId,
   					'action' => 'DIALING'
   			)
   		);   	
   		$faxSpoolLogTable = $this->faxSpoolLogTable;
   		
   		$faxSpoolLogId = $faxSpoolLogTable->saveLogEntry($faxSpoolLog);
   		return $faxSpoolLogId; 
   }
   protected function dialFaxNum()
   {
   	$extension = $this->varManager->getExten();   	
   	try {
   		$localChannelDescriptor = new LocalDialDescriptor(
   				$extension,
   				$this->appConfig->getVpbxDialoutContextName()
   		);
   		$result = $this->agi->dial($localChannelDescriptor);
   	}
   	catch (ChannelDownException $e)
   	{
   	
   	}
   	return $result;
   }
   protected function updateDialingAttemptLog($faxSpoolLogId,$result)
   {
       $agi = $this->agi;
   		$faxSpoolLog = new FaxSpoolLog();
   	
   		$faxSpoolLog->id = $faxSpoolLogId;
   	 
   		$faxSpoolLog->result = ($result->isSuccess())?'SUCCESS':'FAILURE';
   	
   		if (!$result->isSuccess())
   		{
   			$faxSpoolLog->reason = $agi->getFullVariable('DIALSTATUS');
   		}
   		$faxSpoolLogTable = $this->faxSpoolLogTable;
   		$attemptId = $faxSpoolLogTable->saveLogEntry($faxSpoolLog);
   		$agi = $this->agi->setVariable('__ATTEMPT_ID',$attemptId);
   }
   public function hangupAction()
   {
   	
   }
   
}