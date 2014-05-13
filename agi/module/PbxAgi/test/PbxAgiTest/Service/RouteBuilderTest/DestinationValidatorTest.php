<?php
namespace PbxAgiTest\Service\RouteBuilderTest;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\RouteBuilder\DestinationValidatorFactory;
use PbxAgi\RegEntry\Model\RegEntry;
use Zend\Db\ResultSet\ResultSet;


class DestinationValidatorTest extends PHPUnit_Framework_TestCase
{
	public $mockedRegEntryTable;
	public $destinationValidator;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new DestinationValidatorFactory();

        
        $mockedRegEntryTable = $this->getMock('PbxAgi\RegEntry\Model\RegEntryTable',
        		array('fetchAll'), array(), '', false);
        
        $serviceManager->setService('PbxAgi\RegEntry\Model\RegEntryTable', $mockedRegEntryTable);
        
        $this->mockedRegEntryTable = $mockedRegEntryTable;
        $factory->createService($serviceManager);
        $destinationValidator = $factory->createService($serviceManager);        
        $this->destinationValidator = $destinationValidator;
    }
    public function testValidatorReturnsTrueOnValidInput()
    {
        $this->destinationValidator->setNumber('6408040');
        $regentry = new RegEntry();
        $data = array(
            'numbermatchref'=>10,
            'regexpression'=>'/^\d{7}$/'
        );
 
        $regentry->exchangeArray($data);
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new RegEntry());
        $resultSet->initialize(array($regentry));
        
        
    	$this->mockedRegEntryTable->expects($this->once())
    	                          ->method('fetchAll')
    	                          ->with(array('numbermatchref'=> 10))
    	                          ->will($this->returnValue($resultSet));
    	$this->assertTrue($this->destinationValidator->validate(10),'Destination Validator should return valid on valid input');
    }
    public function testNumberSetterAndGetterPerformsCorrectly()
    {
        $destionationValidator = $this->destinationValidator;
        $this->assertNull($destionationValidator->getNumber(), 'Destination number should initially be null');
    	$destionationValidator->setNumber('6001212');
    	$this->assertSame('6001212', $destionationValidator->getNumber(),'Destination number should be retrived equivalent to the one set up');
    }
}