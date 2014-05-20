<?php
namespace Maintainer\Service\BackupRecording;

use Maintainer\Service\AppConfig\AppConfigInterface;
use Maintainer\Service\BackupRecording\BackupRecordingMediaInterface;

class BackupRecordingMedia implements BackupRecordingMediaInterface
{
    protected $appConfig;
    public function __construct(AppConfigInterface $appConfig)
    {
        $this->appConfig = $appConfig;
    }
    public function doCopy($backedId)
    {
        $appConfig = $this->appConfig;
        $mediareposDir = $appConfig->getMediareposDir();        
        $filePath = "{$mediareposDir}/{$backedId}.mp3";
        $backupPath = $appConfig->getBackupPath();
        $backupDestination = "{$backupPath}/{$backedId}.mp3";
        $copyResult = copy($filePath, $backupDestination);
        if (!$copyResult)
        {
            throw new \Exception("Failure to copy {$backupDestination}");
        }                
        return true;
    }
}