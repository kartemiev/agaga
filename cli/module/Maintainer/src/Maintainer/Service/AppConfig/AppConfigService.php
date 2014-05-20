<?php
namespace Maintainer\Service\AppConfig;

use Maintainer\Service\AppConfig\AppConfigInterface;
use Zend\Stdlib\AbstractOptions;

class AppConfigService extends AbstractOptions implements AppConfigInterface
{   
    protected $callRecordFileExtension;     
    protected $mediareposDir;
    protected $backupPath;
    protected $lockFile;

 public function getCallRecordFileExtension() {
  return $this->callRecordFileExtension;
 }
 
 public function setCallRecordFileExtension($callRecordFileExtension) {
  $this->callRecordFileExtension = $callRecordFileExtension;
  return $this;
 }
 
 public function getMediareposDir() {
  return $this->mediareposDir;
 }
 
 public function setMediareposDir($mediareposDir) {
  $this->mediareposDir = $mediareposDir;
  return $this;
 }

 public function getBackupPath() {
  return $this->backupPath;
 }
 
 public function setBackupPath($backupPath) {
  $this->backupPath = $backupPath;
  return $this;
 }

 public function getLockFile() {
  return $this->lockFile;
 }
 
 public function setLockFile($lockFile) {
  $this->lockFile = $lockFile;
  return $this;
 }
 
 
 
    
}

