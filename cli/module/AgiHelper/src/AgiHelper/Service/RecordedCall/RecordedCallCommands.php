<?php 
namespace AgiHelper\Service\RecordedCall;

use AgiHelper\Service\RecordedCall\RecordedCallCommandsInterface;
use AgiHelper\Service\AppConfig\AppConfigInterface;

class RecordedCallCommands implements RecordedCallCommandsInterface
{
	protected $srcMedia;
	protected $dstFileSize;
	protected $appConfig;
	public function __construct(AppConfigInterface $appConfig)
	{
		$this->appConfig = $appConfig;
	}
	public function convert($filename)
	{
		$appConfig = $this->appConfig;
		$dstFileName = $appConfig->getMediareposDir().'/'.$filename.'.mp3';
		$returnCode = exec(sprintf($appConfig->getMediaConverterPath().' -b16 "%s" "%s"', $this->srcMedia, $dstFileName));				 
		$this->dstFileSize = filesize($dstFileName);
		return true;
	}
	public function cleanUp()
	{
		return unlink($this->srcMedia);;
	}
	public function setSrcMedia($srcMedia)
	{
		$this->srcMedia = $srcMedia;
		return $this;
	}
	public function getSrcMedia()
	{
		return $this->srcMedia;
	}
	public function getDstFileSize()
	{
		return $this->dstFileSize;
	}
}