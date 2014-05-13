<?php
namespace PbxAgiTest\Model\Context;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\CallCentreStatus\Model\CallCentreStatusTable;
use PbxAgi\CallCentreStatus\Model\CallCentreStatus;
use PbxAgi\Conference\Model\Conference;
use PbxAgi\Conference\Model\ConferenceTable;
use PbxAgi\Context\Model\Context;
use PbxAgi\Context\Model\ContextTable;

class ContextTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetrieveAnContextByItsId()
    {
    	$context = new Context();
    	$context->exchangeArray(array(
    	               'id' => 1,
    	    'custname'     => 'IVR Тест',
    	    'custdesc'     => '',
    	    'contexttype'     => 'IVR',
    	    'internalref'     => 1,
    	    'ivrref'     => 1,
    	    'funcref'     => 1
    	           ));
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Context());
    	$resultSet->initialize(array($context));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $id = 1;
        $filter = ['id'=>1];
        $limit = 1;
    	$mockTableGateway->expects($this->once())
    	->method('select')
    	->with( $filter)
    	->will($this->returnValue($resultSet));
    
    	$contextTable = new ContextTable($mockTableGateway);
    
     	$this->assertSame($context, $contextTable->getContext(1));
    	 
    }
   
    	
}