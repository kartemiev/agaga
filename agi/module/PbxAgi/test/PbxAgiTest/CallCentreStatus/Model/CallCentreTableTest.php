<?php
namespace PbxAgiTest\CallCentreStatus\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\CallCentreStatus\Model\CallCentreStatusTable;
use PbxAgi\CallCentreStatus\Model\CallCentreStatus;

class CallCentreStatusTableTest extends PHPUnit_Framework_TestCase
{
	public function testFetchAllReturnsAllCallCentreRecords()
	{
	    $callcentrestatus  = new CallCentreStatus();
	    $callcentrestatus->exchangeArray(array('statutory'     => true,
	    		'overridestatus' => 'default',
	    		'status'  => true));	     
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new CallCentreStatus());
		$resultSet->initialize(array($callcentrestatus));
		
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
				array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with()
		                  ->will($this->returnValue($resultSet));

		$callCentreTable = new CallCentreStatusTable($mockTableGateway);

		$this->assertSame($resultSet, $callCentreTable->fetchAll());
	}
	
}