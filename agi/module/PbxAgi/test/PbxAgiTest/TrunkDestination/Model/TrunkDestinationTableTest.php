<?php
namespace PbxAgiTest\TrunkDestination\Model;

use PbxAgi\TrunkDestination\Model\TrunkDestinationTable;
use PbxAgi\TrunkDestination\Model\TrunkDestination;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class TrunkDestinationTableTest extends PHPUnit_Framework_TestCase
{
	public function testFetchAllReturnsAllTrunkDestinations()
	{
		$resultSet        = new ResultSet();
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
				array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		->method('select')
		->with()
		->will($this->returnValue($resultSet));
        
		$trunkDestinationTable = new TrunkDestinationTable($mockTableGateway);

		$this->assertSame($resultSet, $trunkDestinationTable->fetchAll(null));
	}
	public function testCanRetrieveAnTrunkDestinationByItsTrunkDestination()
	{
		$trunkdestination = new TrunkDestination();
		$trunkdestination->exchangeArray(array(
 		         'trunkref'=> 197,
 				 'numbermatchref'=> 21,
				 'routeref'=> 10,				
 				)
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new TrunkDestination());
		$resultSet->initialize(array($trunkdestination));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		->method('select')
		->with(array('routeref' => 10))
		->will($this->returnValue($resultSet));
	
		$trunkDestinationTable = new TrunkDestinationTable($mockTableGateway);
	
		$this->assertSame($trunkdestination, $trunkDestinationTable->fetchAll(array('routeref'=>10))->current());
	}
}