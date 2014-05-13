<?php
namespace PbxAgi\Service\Reader;

use Zend\Mime\Message as MimeMessage;

interface ReaderInterface
{
	function getReadedValue();	
}