<?php
namespace PbxAgiTest\RegEntry\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\RegEntry\Model\RegEntry;
use PbxAgi\RegEntry\Model\RegEntryTable;
 
class RegEntryTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetrieveAllRegEntries()
    {
    	 $data = array(		          
		         'numbermatchref'=> 1,
		         'regexpression'=> '/^7/'		    
		    );  
    	$regentry = new RegEntry();
    	$regentry->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new RegEntry());
    	$resultSet->initialize(array($regentry));
    
    	$filter = null;
    	
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(function (Select $select) use ($filter) {
			                 $select->order('id ASC');
			                 $select->where($filter);
		                  }
		                  )
    	                 ->will($this->returnValue($resultSet));
    
    	$regentryTable = new RegEntryTable($mockTableGateway);
    
    	$this->assertSame($resultSet, $regentryTable->fetchAll());
    }
 }