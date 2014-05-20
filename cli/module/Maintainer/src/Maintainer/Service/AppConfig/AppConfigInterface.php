<?php
namespace Maintainer\Service\AppConfig;

interface AppConfigInterface
{
    function getCallRecordFileExtension();    
    function setCallRecordFileExtension($callRecordFileExtension);    
    function getMediareposDir();    
    function setMediareposDir($mediareposDir);    
    function getBackupPath();
    function setBackupPath($backupPath);    
    function getLockFile();
    function setLockFile($lockFile);
    
}
    