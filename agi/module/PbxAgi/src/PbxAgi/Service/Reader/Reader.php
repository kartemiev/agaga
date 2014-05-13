<?php
namespace PbxAgi\Service\Reader;

use Zend\Mime\Message as MimeMessage;
use PbxAgi\Service\Reader\ReaderInterface;


class Reader implements ReaderInterface
{
    const STREAM_READ = 'php://stdin';

    protected $streamHandle;

    public function __construct($stream = self::STREAM_READ)
    {
        $this->streamHandle = fopen($stream, 'r');
    }

    public function getReadedValue()
    {
        $message ='';
        $stdin = $this->streamHandle;
    	while($line = fgets($stdin)) {
    		$message .= $line;
    	}
    	fclose($stdin);
     	return $message;
    }

    public function __destruct()
    {
        fclose($this->streamHandle);
    }
}