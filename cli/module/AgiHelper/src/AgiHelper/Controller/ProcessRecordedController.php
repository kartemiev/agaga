<?php
namespace AgiHelper\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use AgiHelper\RecordedCall\Model\RecordedCallTableInterface;
use AgiHelper\Service\RecordedCall\RecordedCallCommandsInterface;
use AgiHelper\RecordedCall\Model\RecordedCall;
use AgiHelper\Service\RecordedCall\PurgeOldRecordings;

class ProcessRecordedController extends AbstractActionController
{
	protected $recordedCallTable;
	protected $recordedCallCommands;
	protected $purgeOldRecordings;
	public function __construct(
			RecordedCallTableInterface $recordedCallTable,
			RecordedCallCommandsInterface $recordedCallCommands,
			PurgeOldRecordings $purgeOldRecordings
		)
	{
		$this->recordedCallTable = $recordedCallTable;
		$this->recordedCallCommands = $recordedCallCommands;
		$this->purgeOldRecordings = $purgeOldRecordings;
	}
    public function indexAction()
    {
    	$filename = $this->params('filename');
    	$recordedCallCommands = $this->recordedCallCommands;    	
    	$recordedCallCommands->convert($filename);
    	$recordedCallCommands->cleanUp();
    	$recordedCallTable = $this->recordedCallTable;
    	$recordedcall = new RecordedCall();
    	$fileSize = $recordedCallCommands->getDstFileSize();
    	$recordedcall->exchangeArray(array(
    		'cdrref'=>$filename,
    		'filesize'=>$fileSize,
    		'status'=>'EXISTS'
    	));
    	$recordedCallTable->saveRecordedCall($recordedcall);    
    	$purgeOldRecordings = $this->purgeOldRecordings;
    	$purgeOldRecordings();
    }
  }
