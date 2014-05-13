<?php
namespace PbxAgiTest\Service\FaxParse;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Zend\Mail\Message as MailMessage;
use PbxAgi\Entity\IncomingMessage;
use PbxAgi\Service\FaxParse\FaxRetrieveSender;

class FaxRetrieveSenderTest extends PHPUnit_Framework_TestCase
{
	protected $faxRetrieveSender;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $this->faxRetrieveSender  = new FaxRetrieveSender();                
    }
    public function testFaxAttachmentFormatPresentReturnsTrueOnMessageContainsAttachments()
    {
        $msg = MailMessage::fromString(require 'SampleFaximile.php');
        $incomingMessage = new IncomingMessage();
        $incomingMessage->create($msg);
        $this->assertSame('kartemiev@gmail.com',$this->faxRetrieveSender->getSender($incomingMessage), "Sender retrived should be the same as the sample messages's originator");        
    }
}