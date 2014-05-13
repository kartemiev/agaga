<?php
namespace PbxAgiTest\Entity;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\Entity\IncomingMessage;
 
class IncomingMessageTest extends PHPUnit_Framework_TestCase
{
    public function testIncomingMessageInitialState()
    {
        
        $incomingmessage = new IncomingMessage();
        
    	$this->assertNull($incomingmessage->getMsg(), '"msg" should initially be null');
    	$this->assertNull($incomingmessage->getMimemessage(), '"mimemessage" should initially be null');   	 
    }
    public function testSettersAndGettersPerformCorrectly()
    {
    	$incomingmessage = new IncomingMessage();
    
    	$this->assertInstanceOf('PbxAgi\Entity\IncomingMessage',  $incomingmessage->setMsg('test1'));
    	$this->assertInstanceOf('PbxAgi\Entity\IncomingMessage', $incomingmessage->setMimemessage('test2'));
        $this->assertSame('test1', $incomingmessage->getMsg());    	 
        $this->assertSame('test2', $incomingmessage->getMimemessage());
        
    	
    }    
    
}