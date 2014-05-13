<?php
namespace PbxAgiTest\Service\FaxParse;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Zend\Mail\Message as MailMessage;
use PbxAgi\Entity\IncomingMessage;
use PbxAgi\Service\FaxParse\FaxRetrieveSender;
use PbxAgi\Service\FaxParse\FaxSenderValidatorFactory;
use PbxAgi\FaxUser\Model\FaxUser;

class FaxSenderValidatorTest extends PHPUnit_Framework_TestCase
{
	protected $faxSenderValidator;
	protected $mockedFaxUserTable;
	protected $mockedFaxRetrieveSender;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
        $mockedFaxUserTable = $this->getMock('PbxAgi\FaxUser\Model\FaxUserTable', array('getFaxUserByEmail'), array(), '', false);

        $serviceManager->setService('PbxAgi\FaxUser\Model\FaxUserTable',$mockedFaxUserTable);
        $this->mockedFaxUserTable = $mockedFaxUserTable;        
        $mockedFaxRetrieveSender = $this->getMock('PbxAgi\Service\FaxParse\FaxRetrieveSender', array('getSender'), array(), '', false);
        $serviceManager->setService('PbxAgi\Service\FaxParse\FaxRetrieveSender',$mockedFaxRetrieveSender);        
        $this->mockedFaxRetrieveSender = $mockedFaxRetrieveSender;
         
        $factory  = new FaxSenderValidatorFactory();                
        $this->faxSenderValidator = $factory->createService($serviceManager);
    }
    public function testValidFaxSenderReturnsTrueOnValidation()
    {
        $msg = MailMessage::fromString(require 'SampleFaximile.php');
        $incomingMessage = new IncomingMessage();
        $incomingMessage->create($msg);
        
        $this->mockedFaxRetrieveSender->expects($this->once())
                                      ->method('getSender')
                                      ->with($incomingMessage)
                                      ->will($this->returnValue('kartemiev@gmail.com'));
        
        $faxuser = new FaxUser();
        $this->mockedFaxUserTable->expects($this->once())
                                      ->method('getFaxUserByEmail')
                                      ->with('kartemiev@gmail.com')
                                      ->will($this->returnValue($faxuser));
        $this->assertTrue($this->faxSenderValidator->isValid($incomingMessage),'FaxSender validator should return true on valid input');
        
        
    }
    public function testInvalidFaxSenderReturnsFalseOnValidation()
    {
    	$msg = MailMessage::fromString(require 'SampleFaximile.php');
    	$incomingMessage = new IncomingMessage();
    	$incomingMessage->create($msg);
    
    	$this->mockedFaxRetrieveSender->expects($this->once())
    	                              ->method('getSender')
    	                              ->with($incomingMessage)
    	                              ->will($this->returnValue('kartemiev@gmail.com'));
    
    	$this->mockedFaxUserTable->expects($this->once())
    	                         ->method('getFaxUserByEmail')
    	                         ->with('kartemiev@gmail.com')
    	                         ->will($this->returnValue(null));
    	$this->assertFalse($this->faxSenderValidator->isValid($incomingMessage),'FaxSender validator should return true on valid input');
    
    
    }
    
}