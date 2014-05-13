<?php
namespace PbxAgiTest\NumberMatch\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\NumberMatch\Model\NumberMatch;
use PbxAgi\NumberMatch\Model\NumberMatchTable;

class NumberMatchTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetrieveANumberMatchByItsId()
    {
        $data = array(
	         'custname'=> 'Только москва',
		         'regentries'=> 1,		    
                 'custdesc'=> ''		
                );
        
    	$numbermatch = new NumberMatch();
    	$numbermatch->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new NumberMatch());
    	$resultSet->initialize(array($numbermatch));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('id'=>1))
    	                 ->will($this->returnValue($resultSet));
    
    	$numberMatchTable = new NumberMatchTable($mockTableGateway);
    
    	$this->assertSame($numbermatch, $numberMatchTable->getNumberMatch(1));
    }
    public function testCanRetrieveAllNumberMatchRecords()
    {
    	$data = array(
	         'custname'=> 'Только москва',
		         'regentries'=> 1,		    
                 'custdesc'=> ''		
                );    
    	$numbermatch = new NumberMatch();
    	$numbermatch->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new NumberMatch());
    	$resultSet->initialize(array($numbermatch));
    
    	$orderseq = null;
    	$filter = null;
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(function(Select $select) use ($filter, $orderseq){
	        	$select->where($filter);
	    	}
		)
    	                 ->will($this->returnValue($resultSet));
    
    	$numbermatchTable = new NumberMatchTable($mockTableGateway);
    
    	$this->assertSame($resultSet, $numbermatchTable->fetchAll());
    }
 }