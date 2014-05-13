<?php
namespace PbxAgiTest\TrunkAssoc\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\TrunkAssoc\Model\TrunkAssocTable;
use PbxAgi\TrunkAssoc\Model\TrunkAssoc;

class TrunkAssocTableTest extends PHPUnit_Framework_TestCase
{
	public function testCanRetrieveATrunkAssocByTrunkId()
	{
		$trunkassoc = new TrunkAssoc();
		$trunkassoc->exchangeArray(array(        		
        	    'id' => 1,
                'trunkref' => 2,
                'contextref' => 3           
        )
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new TrunkAssoc());
		$resultSet->initialize(array($trunkassoc));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('trunkref'=>2))
		                 ->will($this->returnValue($resultSet));
	
		$trunkAssocTable = new TrunkAssocTable($mockTableGateway);
	
		$this->assertSame($trunkassoc, $trunkAssocTable->getTrunkAssocByTrunkId(2));
	}

	public function testCanRetrieveAllTrunkAssoc()
	{
		$trunkassoc = new TrunkAssoc();
		$trunkassoc->exchangeArray(array(        		
        	    'id' => 1,
                'trunkref' => 2,
                'contextref' => 3           
        )
		);
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new TrunkAssoc());
		$resultSet->initialize(array($trunkassoc));
		$filter = null;
		$limit = null;		
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(function(Select $select) use ($filter, $limit){
	        	$select->where($filter)
	        		   ->limit($limit);
	    	}
		                     
		)
		                 ->will($this->returnValue($resultSet));
	
		$trunkAssocTable = new TrunkAssocTable($mockTableGateway);
	
		$this->assertSame($resultSet, $trunkAssocTable->fetchAll());
	}	
 
}