<?php
namespace PbxAgiTest\CallDestinaton\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\CallDestination\Model\CallDestination;
use PbxAgi\CallDestination\Model\CallDestinationTable;

class CallDestinationTableTest extends PHPUnit_Framework_TestCase
{
	public function testFetchAllReturnsAllCallDestinationRecords()
	{
	    $calldestination  = new CallDestination();
	    $calldestination->exchangeArray(array('peerid' => '0001',
    			       'number'     => '84956408040',
    			       'duration'  => 30));	     
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new CallDestination());
		$resultSet->initialize(array($calldestination));
		
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
				array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with()
		                  ->will($this->returnValue($resultSet));

		$callDestinationTable = new CallDestinationTable($mockTableGateway);

		$this->assertSame($resultSet, $callDestinationTable->fetchAll());
	}
	public function testCanDeleteCallDestinationById()
	{
		 
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
				array('delete'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('delete')
		                 ->with(array('peerid'=>3))
		                 ->will($this->returnValue(null));
	
		$calldestinationTable = new CallDestinationTable($mockTableGateway);
	
		$calldestinationTable->deleteCallDestinations(3);
	}
	
	public function testCanSaveCallDestination()
	{
	    $data = array('peerid' => '0001',
	    		'number'     => '84956408040',
	    		'duration'  => 30);
	   $calldestination = new CallDestination();
	   $calldestination->exchangeArray($data); 
	   
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
				array('insert'), array(), '', false);
		$mockTableGateway->expects($this->once())
		->method('insert')
		->with($data)
		->will($this->returnValue(null));
	
		$calldestinationTable = new CallDestinationTable($mockTableGateway);
	
		$calldestinationTable->SaveCallDestination($calldestination);
	}
}