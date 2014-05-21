<?php
namespace AgiHelper\Service\RecordedCall;

use AgiHelper\Service\AppConfig\AppConfigInterface;
use AgiHelper\RecordedCall\Model\RecordedCallTableInterface;
use AgiHelper\RecordedCallsSize\Model\RecordedCallsSizeTable;
use AgiHelper\Cdr\Model\CdrTableInterface;

class PurgeOldRecordings
{
	protected $appConfig;
	protected $recordedCallTable;
	protected $recordedCallsSizeTable;
	protected $cdrTable;
	public function __construct(
			AppConfigInterface $appConfig,
			RecordedCallTableInterface $recordedCallTable,
			RecordedCallsSizeTable $recordedCallsSizeTable,
			CdrTableInterface $cdrTable
			)
	{
		$this->appConfig = $appConfig;
		$this->recordedCallTable = $recordedCallTable;
		$this->recordedCallsSizeTable = $recordedCallsSizeTable;
		$this->cdrTable = $cdrTable;
	}
	public function __invoke()
	{
		$recordedCallTable = $this->recordedCallTable;
		$recordedcalls = $recordedCallTable->fetchAll(array('status'=>'EXISTS'), 'id ASC');
		$appConfig = $this->appConfig;
		$imposedLimit = $appConfig->getRecordingLimitMb()*1024*1024;
		$recordedCallsSizeTable = $this->recordedCallsSizeTable;
		$cdrTable = $this->cdrTable;
		$cdrTable->beginTransaction();
		$totalSize = $recordedCallsSizeTable->getTotalSize();
 		while ($totalSize>$imposedLimit)
		{
			$recordedcall = $recordedcalls->next();
			$recordedcall->status = 'DELETED';
			$recordedCallTable->saveRecordedCall($recordedcall);
			$cdrResultSet = $cdrTable->fetchAll(array('recordedname'=>$recordedcall->cdrref),'id ASC');
			$cdr = $cdrResultSet->current();
			$cdr->recordedname = '';
			$cdrTable->saveCdr($cdr);			
			$this->deleteRecordingFromDisk($name);			
			$totalSize = $totalSize - $recordedcall->filesize;
		}
		$cdrTable->commit();
	}
	protected function deleteRecordingFromDisk($name)
	{
		$recordingPath = $this->appConfig->getMediareposDir().'/'.$name.'.mp3';
		unlink($recordingPath);
	}
}