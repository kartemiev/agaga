<?php
namespace PbxAgiTest\Route\Model;

use PbxAgi\Route\Model\RouteTable;
use PbxAgi\Route\Model\Route;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class RouteTableTest extends PHPUnit_Framework_TestCase
{
	public function testFetchAllReturnsAllRoutes()
	{
		$resultSet        = new ResultSet();
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
				array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		->method('select')
		->with()
		->will($this->returnValue($resultSet));
        
		$routeTable = new RouteTable($mockTableGateway);

		$this->assertSame($resultSet, $routeTable->fetchAll(null));
	}
	public function testCanRetrieveAnRoutesByItsId()
	{
		$route = new Route();
		$route->exchangeArray(array(
				 'id'     => 10,
		         'custname'=>'ТФОП 4997777777',
		         'custdesc'=>NULL,
				 'isdefault'=>true
				)
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Route());
		$resultSet->initialize(array($route));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		->method('select')
		->with(array('id' => 10))
		->will($this->returnValue($resultSet));
	
		$routeTable = new RouteTable($mockTableGateway);
	
		$this->assertSame($route, $routeTable->getRoute(10));
	}
	public function testExceptionIsThrownWhenGettingNonexistentRoute()
	{
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Route());
		$resultSet->initialize(array());
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		->method('select')
		->with(array('id' => 10))
		->will($this->returnValue($resultSet));
	
		$routeTable = new RouteTable($mockTableGateway);
	
		try
		{
			$routeTable->getRoute(10);
		}
		catch (\Exception $e)
		{
			$this->assertSame('Could not find row 10', $e->getMessage());
			return;
		}
	
		$this->fail('Expected exception was not thrown');
}
}