<?php
namespace PbxAgiTest\Service\DialString\SimpleTimeParser;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\DialString\SimpleTimeParserFactory;

class SimpleTimeParser extends PHPUnit_Framework_TestCase
{
 
    protected $mockedDateTime;
    protected $simpleTimeParser;
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
          
         $simpleTimeParserFactory = new SimpleTimeParserFactory();
         $simpleTimeParser = $simpleTimeParserFactory->createService($serviceManager);
         $this->simpleTimeParser = $simpleTimeParser;
     }
     public function testSimpleTimeParserReturnsCorrectResultOnSampleData()
     {
         $dateTime = new \DateTime();
         $dateTime->setTime(23, 30, 0);
          $this->assertEquals($dateTime, $this->simpleTimeParser->__invoke('2330'),'SimpleTimeParser should have returned data object with correct properties once invoked with correct parameters');
     }
     public function testSimpleTimeParserReturnsFalseOnIncorrectDataWrongHours()
     {
     
     	$this->assertFalse($this->simpleTimeParser->__invoke('2430'), 'SimpleTimeParser should have returned false when invoked with incorrect hours');
     }
     public function testSimpleTimeParserReturnsFalseOnIncorrectDataWrongMinutes()
     {
     	 
     	$this->assertFalse($this->simpleTimeParser->__invoke('2160'), 'SimpleTimeParser should have returned false when invoked with incorrect minutes');
     }
     public function testSimpleTimeParserReturnsFalseOnIncorrectDataWrongBothHoursAndMinutes()
     {     	 
     	$this->assertFalse($this->simpleTimeParser->__invoke('2560'), 'SimpleTimeParser should have returned false when invoked with incorrect hours and minutes altogether');
     }
      
        
}

