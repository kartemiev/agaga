<?php
namespace PbxAgiTest\Service\DialString\SimpleTimeWithoutSemicolumnValidator;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Validator\Time\SimpleTimeWithoutSemicolumnValidator;
  
class SimpleTimeWithoutSemicolumnValidatorTest extends PHPUnit_Framework_TestCase
{
 
    protected $mockedDateTime;
    protected $simpleTimeWithoutSemicolumnValidator;
     public function setUp()
    {     	
        \Logger::shutdown();
        $serviceManager = Bootstrap::getServiceManager();
        $serviceManager->setAllowOverride(true);
        
          
        $mockedDateTime =  $this->getMockBuilder('PbxAgi\GenericWrappers\DateTime')
                                                         ->disableOriginalConstructor()
                                                         ->getMock();
         $this->mockedDateTime = $mockedDateTime;
        
         $serviceManager->setService('PeerTable', 'PbxAgi\GenericWrappers\DateTime');
          
         $simpleTimeWithoutSemicolumnValidator = new SimpleTimeWithoutSemicolumnValidator();
         $this->simpleTimeWithoutSemicolumnValidator = $simpleTimeWithoutSemicolumnValidator;
     }
     public function testSimpleTimeWithoutSemicolumnValidatorReturnsTrueOnCorrectSampleData()
     {
 
          $this->assertTrue($this->simpleTimeWithoutSemicolumnValidator->__invoke('2330'),'SimpleTimeWithoutSemicolumnValidator should have returned true when invoked with correct value');
     }
     public function testSimpleTimeWithoutSemicolumnValidatorReturnsFalseOnInvalidSampleData()
     {
     
     	$this->assertFalse($this->simpleTimeWithoutSemicolumnValidator->__invoke('2470'),'SimpleTimeWithoutSemicolumnValidator should have returned false when invoked with invalid value');
     }
}

