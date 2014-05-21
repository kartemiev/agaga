<?php
namespace AgiHelper\Service\AppConfig;

use AgiHelper\Service\AppConfig\AppConfigInterface;
use Zend\Stdlib\AbstractOptions;

class AppConfigService extends AbstractOptions implements AppConfigInterface
{   
    protected $callRecordFileExtension;     
    protected $mediareposDir;
    protected $mediaConverterPath;
    protected $recordingLimitMb;

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
 public function getMediaConverterPath()
 {
 	return $this->mediaConverterPath;
 }
 public function setMediaConverterPath($mediaConverterPath)
 {
 	$this->mediaConverterPath = $mediaConverterPath;
 	return $this;
 }    
 public function getRecordingLimitMb()
 {
 	return $this->recordingLimitMb;
 }
 public function setRecordingLimitMb($recordingLimitMb)
 {
 	$this->recordingLimitMb = $recordingLimitMb;
 	return $this;
 }
 
}

