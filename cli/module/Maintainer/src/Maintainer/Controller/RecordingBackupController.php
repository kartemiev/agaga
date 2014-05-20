<?php
namespace Maintainer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Where;
use Maintainer\Cdr\Model\CdrTableInterface;
use Maintainer\Service\AppConfig\AppConfigInterface;
use Maintainer\Cdr\Model\Cdr;
use Maintainer\Service\BackupRecording\BackupDomDocumentInterface;
use Maintainer\Service\BackupRecording\BackupDomDocumentWriterInterface;
use Maintainer\Service\BackupRecording\BackupRecordingMediaInterface;
use Maintainer\Service\BackupRecording\BackupRecordingException;
use Maintainer\Service\LockHandler\LockHandlerInterface;

class RecordingBackupController extends AbstractActionController
{
    protected $cdrTable;
    protected $appConfig;
    protected $backupDomDocument;
    protected $backupDomDocumentWriter;
    protected $backupRecordingMedia;
    protected $lockHandler;
    public function __construct(
        AppConfigInterface $appConfig, 
        CdrTableInterface $cdrTable,
        BackupDomDocumentInterface $backupDomDocument,
        BackupDomDocumentWriterInterface $backupDomDocumentWriter,
        BackupRecordingMediaInterface $backupRecordingMedia,
        LockHandlerInterface $lockHandler
    )
    {
        $this->cdrTable = $cdrTable;
        $this->appConfig = $appConfig;
        $this->backupDomDocument = $backupDomDocument;
        $this->backupDomDocumentWriter = $backupDomDocumentWriter;
        $this->backupRecordingMedia = $backupRecordingMedia;
        $this->lockHandler = $lockHandler;
    }
    public function indexAction()
    {
        $appConfig = $this->appConfig;
        $lockHandler = $this->lockHandler;
        $lockFileName = $appConfig->getLockFile();
        $lockHandler->setLockFileName($lockFileName);
        if ($lockHandler->isLocked())
        {
            echo "Program is locked - file {$lockFileName} exists\n\n";
            return;
        }
        $lockHandler->touchLock();
        try {
            $cdrTable = $this->cdrTable;
            $cdrs = $this->getAllPendingRecordings();    
            $cdrTable->beginTransaction();
            foreach ($cdrs as $cdr)
            {
                try {
                     $xmlString = $this->backupDomDocument->assemble($cdr);                     
                    $xmlFileName = $appConfig->getBackupPath().'/'.$cdr->userfield.'.xml';
                    $this->backupDomDocumentWriter->flush($xmlString, $xmlFileName);
                    $this->backupRecordingMedia->doCopy($cdr->userfield);
                    $cdr->backupdate = date('Y-m-d H:i:s');
                    $cdrTable->updateBackupDateOnly($cdr->id);
                } catch (\Exception $e)
                {
                    $message = $e->getMessage();
                    echo "{$message}\n";
                    continue;
                }
            }
            $cdrTable->commit();            
        
        } catch (\Exception $e)
        {
            $lockHandler->closeLock();
            throw new \Exception('Exception incurred during processing', null, $e);
        }
        
        $lockHandler->closeLock();
    }
    protected function getAllPendingRecordings()
    {
        $filter = new Where();
        $filter->notEqualTo('userfield', '')->and->isNull('backupdate');
        $cdrs = $this->cdrTable->fetchAll($filter, 'calldate ASC');
        return $cdrs;
    }
  }
