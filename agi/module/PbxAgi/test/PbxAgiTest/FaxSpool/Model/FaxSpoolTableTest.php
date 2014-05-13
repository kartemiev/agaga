<?php
namespace PbxAgiTest\FaxSpoolTest\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\FaxSpool\Model\FaxSpool;
use PbxAgi\FaxSpool\Model\FaxSpoolTable;

class FaxSpoolTableTest extends PHPUnit_Framework_TestCase
{
 
	public function testCanSaveFaxSpoolNonExistingFaxId()
	{
	    $data = array('recordtype' => 1,
		              'uniqueid' => 'тест',
		              'faxstatus'=> 'тест',
		              'pages'=> 1
		              );
 	    
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert','getLastInsertValue'), array(), '', false);
		
		$mockTableGateway->expects($this->once())
		                 ->method('insert')
		                 ->with($data)
		                 ->will($this->returnValue(null));

		$mockTableGateway->expects($this->once())
		->method('getLastInsertValue')
		->with()
		->will($this->returnValue(1));
		
		
		$faxSpoolTable = new FaxSpoolTable($mockTableGateway);
		$faxSpool = new FaxSpool();
		$faxSpool->exchangeArray($data);
		$this->assertEquals(1,$faxSpoolTable->saveFax($faxSpool));		
	}
	public function testCanSaveFaxSpoolWithExistingFaxId()
	{
		$data = array(
		        'recordtype' => 1,
				'uniqueid' => 'тест',
				'faxstatus'=> 'тест',
				'pages'=> 1
		);
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('update','getLastInsertValue'), array(), '', false);
	
		$mockTableGateway->expects($this->once())
		                 ->method('update')
		                 ->with($data,array('id'=>3))
		                 ->will($this->returnValue(null));
	 
		$faxSpoolTable = new FaxSpoolTable($mockTableGateway);
		$faxSpool = new FaxSpool();		
		$faxSpool->exchangeArray($data);
		$faxSpool->id = 3;
		$this->assertEquals(null,$faxSpoolTable->saveFax($faxSpool));
	}
	
}