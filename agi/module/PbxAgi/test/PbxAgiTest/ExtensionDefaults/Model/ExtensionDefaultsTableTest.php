<?php
namespace PbxAgiTest\ExtensionDefaults\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\ExtensionDefaults\Model\ExtensionDefaults;
use PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTable;

class ExtensionDefaultsTableTest extends PHPUnit_Framework_TestCase
{
 
	public function testCanRetrieveAnExtensionDefaultsByVpbxid()
	{
		$extensiondefaults = new ExtensionDefaults();
		$extensiondefaults->exchangeArray(array(
            'vpbxid'=>1,
            'transfer'=>'allowed',
            'statuschange'=>'allowed',
            'incoming'=>'allowed',
            'hold'=>'allowed',
            'forwarding'=>'allowed',
            'number_status'=>'allowed',
            'diversion_unconditional_status'=>'UNDEFINED',
            'diversion_unconditional_number'=>'',
            'diversion_unavail_status'=>'UNDEFINED',
            'diversion_unavail_number'=>'',
            'diversion_busy_status'=>'UNDEFINED',
            'diversion_busy_number'=>'',
            'diversion_noanswer_status'=>'UNDEFINED',
            'diversion_noanswer_number'=>'',    
            'diversion_unconditional_landingtype'=>'',
            'diversion_unavail_landingtype'=>'',
            'diversion_busy_landingtype'=>'',
            'diversion_noanswer_landingtype'=>'',
            'diversion_noanswer_duration'=>30,
            'outgoingcallspermission'=> 'allowed',
            'extensionrecord'=> 'enabled'		    
		)
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new ExtensionDefaults());
		$resultSet->initialize(array($extensiondefaults));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('vpbxid' => 1))
		                 ->will($this->returnValue($resultSet));
	
		$extensionDefaultsTable = new ExtensionDefaultsTable($mockTableGateway);
	
		$this->assertSame($extensiondefaults, $extensionDefaultsTable->getExtensionDefaults(1));
	}
	public function testCanRetrieveAnExtensionDefaultsByVpbxidWhenVpbxNotExists()
	{
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new ExtensionDefaults());
		$resultSet->initialize(array());
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('vpbxid' => 1))
		                 ->will($this->returnValue($resultSet));
	
		$extensionDefaultsTable = new ExtensionDefaultsTable($mockTableGateway);
	
		try
		{
            $extensionDefaultsTable->getExtensionDefaults(1);		}
		catch (\Exception $e)
		{
			$this->assertSame("Could not find row 1", $e->getMessage());
			return;
		}
		 
		$this->fail('Expected exception was not thrown');
		
	}
}