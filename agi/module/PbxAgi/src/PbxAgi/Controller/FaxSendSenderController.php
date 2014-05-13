<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\FaxSpool\Model\FaxSpoolTable;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTable;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLog;


class FaxSendSenderController extends AbstractActionController
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
			FaxSpoolTable $faxSpoolTable,
	        FaxSpoolLogTable $faxSpoolLogTable
	) {
		$this->varManager = $varManager;
		$this->appConfig = $appConfig;
		$this->agi = $agi;
		$this->faxSpoolTable = $faxSpoolTable;
		$this->faxSpoolLogTable = $faxSpoolLogTable;
	}
   public function indexAction()
   {
       
		$agi = $this->agi;
		$attemptId = $agi->getVariable('ATTEMPT_ID');
 		$attemptId = (isset($attemptId))?(int)$attemptId:null;
		$agi->answer();
   		$fileName = $agi->getVariable('FILENAME');
   		$result = $agi->faxSend($fileName);
   		if ($result->isSuccess())
   		{
   		    $data = array(
   		        'id'=> $attemptId,
   		        'reason'=>'RECEIVED',
   		        'result'=>'RECEIVED'
   		    );
   		    $faxspoollog = new FaxSpoolLog();
   		    $faxspoollog->exchangeArray($data);
   	        $this->faxSpoolLogTable->updateResult($faxspoollog);
   		}
   		else 
   		{
   		    $data = array(
   		    		'id'=>(int)$attemptId,
   		    		'reason'=>'FAXSENDFAILED',
   		    		'result'=>'FAILED'
   		    );
   		    $faxspoollog = new FaxSpoolLog();
   		    $faxspoollog->exchangeArray($data);
   		    $this->faxSpoolLogTable->updateResult($faxspoollog);
   		}
   }
   public function hangupAction()
   {
       
   }
   
}