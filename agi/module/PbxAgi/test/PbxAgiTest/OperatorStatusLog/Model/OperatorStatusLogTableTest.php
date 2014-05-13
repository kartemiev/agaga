<?php
namespace PbxAgiTest\OperatorStatusLog\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\OperatorStatusLog\Model\OperatorStatusLog;
use PbxAgi\OperatorStatusLog\Model\OperatorStatusLogTable;
 
class OperatorStatusLogTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanSaveOperatorStatusLog()
    {
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);

    	$data = array(
                 'extension'=> '100',
		         'operatorstatus'=> 'lanch_away'	
    	);
    	$operatorstatuslog = new OperatorStatusLog();
    	$operatorstatuslog->exchangeArray($data);
    	
    	$mockTableGateway->expects($this->once())
    	                 ->method('insert')
    	                 ->with($data)
    	                 ->will($this->returnValue(null));
    
    	$operatorStatusLogTable = new OperatorStatusLogTable($mockTableGateway);
    	$operatorStatusLogTable->addEntry($operatorstatuslog);
    }
 }