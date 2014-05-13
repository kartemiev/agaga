<?php
namespace PbxAgiTest\FaxSpoolLog\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLog;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTable;

class FaxSpoolLogTableTest extends PHPUnit_Framework_TestCase
{
 
	public function testCanSaveFaxSpoolLog()
	{
		$data = array(
 				 'spoolref'=> 2,
		         'action'=> 'тест1',
		         'result'=> 'тест2',
		         'reason'=> 'тест3'	
		                      );
	    $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('insert')
		                 ->with($data)
		                 ->will($this->returnValue(null));
		$faxSpoolLogTable = new FaxSpoolLogTable($mockTableGateway);
		$faxSpoolLog = new FaxSpoolLog();
		$faxSpoolLog->exchangeArray($data);
		$faxSpoolLogTable->saveLogEntry($faxSpoolLog);		
	}
	public function testSaveFaxSpoolLogUpdatesWhenIdIsSet()
	{
		$data = array(
				'spoolref'=> 2,
				'action'=> 'тест1',
				'result'=> 'тест2',
				'reason'=> 'тест3'
		);
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('update'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('update')
		                 ->with($data,array('id'=>10))
		                 ->will($this->returnValue(null));
		$faxSpoolLogTable = new FaxSpoolLogTable($mockTableGateway);
		$faxSpoolLog = new FaxSpoolLog();
		$faxSpoolLog->exchangeArray($data);
		$faxSpoolLog->id = 10;
		$faxSpoolLogTable->saveLogEntry($faxSpoolLog);
	}
	
	public function testCanUpdateResult()
	{
	    $data = array(
 	    		'result'=> 'тест2',
	    		'reason'=> 'тест3'
	    );
	    $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('update'), array(), '', false);
	    $mockTableGateway->expects($this->once())
	    ->method('update')
	    ->with($data,array('id'=>1))
	    ->will($this->returnValue(null));
	    $faxSpoolLogTable = new FaxSpoolLogTable($mockTableGateway);
	    $faxSpoolLog = new FaxSpoolLog();
	    $faxSpoolLog->id = 1;
	    $faxSpoolLog->exchangeArray($data);
	    $faxSpoolLogTable->updateResult($faxSpoolLog);	     
	}
	public function testCanUpdateResultThrowsExceptionWhenIdWasNotSpecified()
	{
		$data = array(
				'result'=> 'тест2',
				'reason'=> 'тест3'
		);
		$faxSpoolLog = new FaxSpoolLog();
 		$faxSpoolLog->exchangeArray($data);
		
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('update'), array(), '', false);
		
		$faxSpoolLogTable = new FaxSpoolLogTable($mockTableGateway);
		
		try
		{
		    $faxSpoolLogTable->updateResult($faxSpoolLog);
		}
			catch (\Exception $e)
			{
				$this->assertSame("id to update not set!", $e->getMessage());
				return;
			}
				
			$this->fail('Expected exception was not thrown');
		
 	}
}