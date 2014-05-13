<?php
namespace PbxAgiTest\SkypeAlias\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\SkypeAlias\Model\SkypeAlias;
use PbxAgi\SkypeAlias\Model\SkypeAliasTable;

class SkypeAliasTableTest extends PHPUnit_Framework_TestCase
{
	public function testCanRetrieveASkypeAliasByItsId()
	{
		$skypealias = new SkypeAlias();
		$skypealias->exchangeArray(array(        		
        		'id'     => 3,
        		'number'=> '12',
        		'skypeid'=>'ivan_ivanov',
        		'custname'=>'Иван Иванов',      
        		'custdesc'=>''                        
            )
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new SkypeAlias());
		$resultSet->initialize(array($skypealias));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('id'=>3))
		                 ->will($this->returnValue($resultSet));
	
		$skypealiasTable = new SkypeAliasTable($mockTableGateway);
	
		$this->assertSame($skypealias, $skypealiasTable->getSkypeAlias(3));
	}

	public function testCanRetrieveASkypeAliasByItsNumber()
	{
		$skypealias = new SkypeAlias();
		$skypealias->exchangeArray(array(
				'id'     => 3,
				'number'=> '12',
				'skypeid'=>'ivan_ivanov',
				'custname'=>'Иван Иванов',
				'custdesc'=>''
		)
		);
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new SkypeAlias());
		$resultSet->initialize(array($skypealias));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('number'=>'12'))
		                 ->will($this->returnValue($resultSet));
	
		$skypealiasTable = new SkypeAliasTable($mockTableGateway);
	
		$this->assertSame($skypealias, $skypealiasTable->getSkypeAliasByExten('12'));
	}
	
	
	
	public function testCanRetrieveAllSkypeAliases()
	{
		$skypealias = new SkypeAlias();
		$skypealias->exchangeArray(array(
				'id'     => 3,
				'number'=> '12',
				'skypeid'=>'ivan_ivanov',
				'custname'=>'Иван Иванов',
				'custdesc'=>''
		  ) 
		);
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new SkypeAlias());
		$resultSet->initialize(array($skypealias));
		$filter = null;
		$limit = null;		
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(function (Select $select) {
                                $select->order('number ASC');
                            }
		                     
		)
		                 ->will($this->returnValue($resultSet));
	
		$skypealiasTable = new SkypeAliasTable($mockTableGateway);
	
		$this->assertSame($resultSet, $skypealiasTable->fetchAll());
	}	
 
}