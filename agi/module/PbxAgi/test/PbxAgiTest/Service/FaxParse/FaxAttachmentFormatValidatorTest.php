<?php
namespace PbxAgiTest\Service\FaxParse;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\FaxParse\FaxAttachmentFormatValidator;
use Zend\Mail\Message as MailMessage;
use PbxAgi\Entity\IncomingMessage;

class FaxAttachmentFormatValidatorTest extends PHPUnit_Framework_TestCase
{
	protected $faxAttachmentFormatValidator;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $this->faxAttachmentFormatValidator = new FaxAttachmentFormatValidator();
                
    }
    public function testFaxAttachmentFormatValidatorReturnsTrueOnMessageContainsAttachments()
    {
        $msg = MailMessage::fromString(require 'SampleFaximile.php');
        $incomingMessage = new IncomingMessage();
        $incomingMessage->create($msg);
        $this->assertTrue($this->faxAttachmentFormatValidator->isValid($incomingMessage));        
    }
}