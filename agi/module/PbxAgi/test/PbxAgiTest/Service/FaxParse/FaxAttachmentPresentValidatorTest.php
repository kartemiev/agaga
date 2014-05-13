<?php
namespace PbxAgiTest\Service\FaxParse;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\FaxParse\FaxAttachmentFormatValidator;
use Zend\Mail\Message as MailMessage;
use PbxAgi\Entity\IncomingMessage;
use PbxAgi\Service\FaxParse\FaxAttachmentPresentValidatorFactory;

class FaxAttachmentPresentValidatorTest extends PHPUnit_Framework_TestCase
{
	protected $faxAttachmentPresentValidator;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory  = new FaxAttachmentPresentValidatorFactory();
        $this->faxAttachmentPresentValidator = $factory->createService($serviceManager);
                
    }
    public function testFaxAttachmentFormatPresentReturnsTrueOnMessageContainsAttachments()
    {
        $msg = MailMessage::fromString(require 'SampleFaximile.php');
        $incomingMessage = new IncomingMessage();
        $incomingMessage->create($msg);
        $this->assertTrue($this->faxAttachmentPresentValidator->isValid($incomingMessage));        
    }
}