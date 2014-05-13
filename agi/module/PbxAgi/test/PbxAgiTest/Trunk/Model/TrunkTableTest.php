<?php
namespace PbxAgiTest\SkypeAlias\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\Trunk\Model\Trunk;
use PbxAgi\Trunk\Model\TrunkTable;

class TrunkTableTest extends PHPUnit_Framework_TestCase
{
	public function testCanRetrieveATrunkByItsId()
	{
		$trunk = new Trunk();
		$trunk->exchangeArray(array(        		
        		'id'     => 3,
        		'secret'=> '12345',
         		'custname'=>'Иван Иванов',      
        		'custdesc'=>'',
                'name'=>'000011',
                'defaultuser'=>'000011',
                'callbackextension'=>'000011',
                'callerid'=>'74956408040'            
        )
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Trunk());
		$resultSet->initialize(array($trunk));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('id'=>3,'peertype'=>'TRUNK'))
		                 ->will($this->returnValue($resultSet));
	
		$trunkTable = new TrunkTable($mockTableGateway);
	
		$this->assertSame($trunk, $trunkTable->getTrunk(3));
	}

    public function testCanRetrieveATrunkByItsCallbackNum()
	{
		$trunk = new Trunk();
		$trunk->exchangeArray(array(        		
        		'id'     => 3,
        		'secret'=> '12345',
         		'custname'=>'Иван Иванов',      
        		'custdesc'=>'',
                'name'=>'000011',
                'defaultuser'=>'000011',
                'callbackextension'=>'000011',
                'callerid'=>'74956408040'            
        )
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Trunk());
		$resultSet->initialize(array($trunk));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('callbackextension'=>'000011','peertype'=>'TRUNK'))
		                 ->will($this->returnValue($resultSet));
	
		$trunkTable = new TrunkTable($mockTableGateway);
	
		$this->assertSame($trunk, $trunkTable->getTrunkByCallbackExten('000011'));
	}
	
	
	public function testCanRetrieveAllTrunks()
	{
		$trunk = new Trunk();
		$trunk->exchangeArray(array(
		    'id'=> 3,
        		'secret'=> '12345',
         		'custname'=>'Иван Иванов',      
        		'custdesc'=>'',
                'name'=>'000011',
                'defaultuser'=>'000011',
                'callbackextension'=>'000011',
                'callerid'=>'74956408040'            
        )
		);
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Trunk());
		$resultSet->initialize(array($trunk));
		$filter = null;
		$limit = null;		
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(function (Select $select) {
     		$select->order('id ASC');
     		$select->where(array('peertype'=>'TRUNK'));     		 
    	}
		                     
		)
		                 ->will($this->returnValue($resultSet));
	
		$trunkTable = new TrunkTable($mockTableGateway);
	
		$this->assertSame($resultSet, $trunkTable->fetchAll());
	}	
 
}