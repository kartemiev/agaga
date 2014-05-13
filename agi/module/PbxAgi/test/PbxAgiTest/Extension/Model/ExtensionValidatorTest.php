<?php
namespace PbxAgiTest\Extension\Model;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Extension\Model\ExtensionValidatorFactory;

class ExtensionValidatorTest extends PHPUnit_Framework_TestCase
{
    protected $extensionValidator;
    protected $mockedExtensionTable;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new ExtensionValidatorFactory();


        $mockedExtensionTable = $this->getMockBuilder('PbxAgi\Extension\Model\ExtensionTable')
                                     ->disableOriginalConstructor()
                                     ->getMock();
        $serviceManager->setService('ExtensionTable',$mockedExtensionTable);
        
        $this->extensionValidator = $factory->createService($serviceManager);
         
        $this->mockedExtensionTable = $mockedExtensionTable;
               	      	       	
    }
    public function testCanExtensionValidatorReturnTrueWhenExtensionIsValid()
    {
        
        $mockedExtensionTable = $this->mockedExtensionTable;
        $mockedExtensionTable->expects($this->once())
                             ->method('isValid')
                             ->with('100')
                             ->will($this->returnValue(true));
         
     	$this->assertTrue($this->extensionValidator->isValid('100'));    	
    }
    public function testCanExtensionValidatorReturnFalseWhenExtensionIsInvalid()
    {
    
    	$mockedExtensionTable = $this->mockedExtensionTable;
    	$mockedExtensionTable->expects($this->once())
    	                     ->method('isValid')
    	                     ->with('100')
    	                     ->will($this->returnValue(false));
    	 
    	$this->assertFalse($this->extensionValidator->isValid('100'));
    }
    
}