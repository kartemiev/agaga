<?php 
namespace AgiHelper\Service\RecordedCall;

interface  RecordedCallCommandsInterface
{
	function convert($filename);
	function cleanUp();
	function setSrcMedia($srcMedia);
	function getSrcMedia();
	function getDstFileSize();
}