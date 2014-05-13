<?php
namespace PbxAgiTest\ExtensionGroup\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\ExtensionGroup\Model\ExtensionGroup;
use PbxAgi\ExtensionGroup\Model\ExtensionGroupTable;

class ExtensionGroupTableTest extends PHPUnit_Framework_TestCase
{
 
	public function testCanRetrieveAnextensionGroupByItsId()
	{
		$extensiongroup = new ExtensionGroup();
		$extensiongroup->exchangeArray(array(
 		         'id'=> 1,
 				 'name'=> 'тест',
				 'transfer'=> 'allowed',
				 'statuschange'=>'allowed',
				 'incoming' => 'forbidden',
				'memberofcallcentreque'=>true,
				'hold'=>'forbidden',
				'forwarding'=>'allowed',
				'custdesc'=>'',
				'group_members_status'=>'ACTIVE',
				'number_status'=>'UNDEFINED'				
 				)
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new ExtensionGroup());
		$resultSet->initialize(array($extensiongroup));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		->method('select')
		->with(array('id' => 1))
		->will($this->returnValue($resultSet));
	
		$extensionGroupTable = new ExtensionGroupTable($mockTableGateway);
	
		$this->assertSame($extensiongroup, $extensionGroupTable->getExtensionGroup(1));
	}
}