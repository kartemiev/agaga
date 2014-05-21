<?php
namespace AgiHelper\Service\AppConfig;

interface AppConfigInterface
{
    function getCallRecordFileExtension();    
    function setCallRecordFileExtension($callRecordFileExtension);    
    function getMediareposDir();    
    function setMediareposDir($mediareposDir);    
	function getMediaConverterPath();
	function setMediaConverterPath($mediaConverterPath);	
	function getRecordingLimitMb();
 	function setRecordingLimitMb($recordingLimitMb);
 }
    