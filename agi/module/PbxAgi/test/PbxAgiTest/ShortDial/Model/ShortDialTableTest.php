<?php
namespace PbxAgiTest\ShortDial\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\ShortDial\Model\ShortDial;
use PbxAgi\ShortDial\Model\ShortDialTable;

class ShortDialTableTest extends PHPUnit_Framework_TestCase
{
	public function testCanRetrieveAnShortDialByItsShort()
	{
		$shortdial = new ShortDial();
		$shortdial->exchangeArray(array(
	            'id'     => 1,
        		'peerid'=> 10,
        		'number'=>'84956408040',
        		'short'=>'12'            				)
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new ShortDial());
		$resultSet->initialize(array($shortdial));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('short'=>'12','peerid'=>10))
		                 ->will($this->returnValue($resultSet));
	
		$shortdialTable = new ShortDialTable($mockTableGateway);
	
		$this->assertSame($resultSet, $shortdialTable->getShortDialByShort('12', '10'));
	}
	
	public function testCanRetrieveAnShortDialByItsId()
	{
		$shortdial = new ShortDial();
		$shortdial->exchangeArray(array(
				'id'     => 2,
				'peerid'=> 10,
				'number'=>'84956408040',
				'short'=>'12'            				)
		);
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new ShortDial());
		$resultSet->initialize(array($shortdial));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('id'=>2))
		                 ->will($this->returnValue($resultSet));
	
		$shortdialTable = new ShortDialTable($mockTableGateway);
	
		$this->assertSame($resultSet, $shortdialTable->getShortDialById(2));
	}
	
	public function testCanRetrieveAllShortDials()
	{
		$shortdial = new ShortDial();
		$shortdial->exchangeArray(array(
				'id'     => 2,
				'peerid'=> 10,
				'number'=>'84956408040',
				'short'=>'12'            				)
		);
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new ShortDial());
		$resultSet->initialize(array($shortdial));
		$filter = null;
		$limit = null;		
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(			
		                     function(Select $select) use ($filter,$limit) {
		                     	$select->where($filter);
		                     	$select->limit($limit);		                     }
		                     
		)
		                 ->will($this->returnValue($resultSet));
	
		$shortdialTable = new ShortDialTable($mockTableGateway);
	
		$this->assertSame($resultSet, $shortdialTable->fetchAll());
	}
	
	
	public function testCanAddShortDial()
	{
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
	
		$data = array(
        		'peerid'=> 10,
        		'number'=>'84956408040',
        		'short'=>'12'    
		);
		$shortdial = new ShortDial();
		$shortdial->exchangeArray($data);
		 
		$mockTableGateway->expects($this->once())
		                 ->method('insert')
		                 ->with($data)
		                 ->will($this->returnValue(null));
	
		$shortdialtable = new ShortDialTable($mockTableGateway);
		$shortdialtable->saveShortDial($shortdial);
	}	 
	
	public function testCanUpdateShortDial()
	{
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('update'), array(), '', false);
	
		$data = array(
		        'id' => 1,
				'peerid'=> 10,
				'number'=>'84956408040',
				'short'=>'12'
		);
		$shortdial = new ShortDial();
		$shortdial->exchangeArray($data);
	    unset($data['id']);
		$mockTableGateway->expects($this->once())
		                 ->method('update')
		                 ->with($data,array('id'=>1))
		                 ->will($this->returnValue(null));
	
		$shortdialtable = new ShortDialTable($mockTableGateway);
		$shortdialtable->saveShortDial($shortdial);
	}
	
	public function testCanDeleteShortDial()
	{
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('delete'), array(), '', false);
	
		
		$mockTableGateway->expects($this->once())
		                 ->method('delete')
		                 ->with(array('id'=>2))
		                 ->will($this->returnValue(null));
	
		$shortdialtable = new ShortDialTable($mockTableGateway);
		$shortdialtable->deleteShortDial(2);
	}
}