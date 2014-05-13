<?php
namespace PbxAgiTest\FaxUser\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\Ivr\Model\Ivr;
use PbxAgi\Ivr\Model\IvrTable;

class IvrTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetrieveAnIvrByItsId()
    {
        $data = array(
	         'custname'=> 'основное приветствие предприятия',
		         'custdesc'=> ''	
                );
        
    	$ivr = new Ivr();
    	$ivr->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Ivr());
    	$resultSet->initialize(array($ivr));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('id'=>1))
    	                 ->will($this->returnValue($resultSet));
    
    	$ivrTable = new IvrTable($mockTableGateway);
    
    	$this->assertSame($ivr, $ivrTable->getIvr(array('id'=>1)));
    }
    public function testCanRetrieveAllIvrRecords()
    {
    	$data = array(
    			'custname'=> 'основное приветствие предприятия',
    			'custdesc'=> ''
    	);
    
    	$ivr = new Ivr();
    	$ivr->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Ivr());
    	$resultSet->initialize(array($ivr));
    
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
    
    	$ivrTable = new IvrTable($mockTableGateway);
    
    	$this->assertSame($resultSet, $ivrTable->fetchAll());
    }
 }