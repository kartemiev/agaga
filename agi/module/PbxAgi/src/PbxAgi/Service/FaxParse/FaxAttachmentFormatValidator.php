<?php
namespace PbxAgi\Service\FaxParse;

use Zend\Validator\AbstractValidator;

class FaxAttachmentFormatValidator extends AbstractValidator
{
	public function isValid($incomingMessage)
	{
	    $result = $incomingMessage->getMimemessage();
	    return ($result)?true:false;
 	} 	
}
