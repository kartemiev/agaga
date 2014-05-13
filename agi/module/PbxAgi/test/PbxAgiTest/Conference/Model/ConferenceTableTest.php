<?php
namespace PbxAgiTest\Conference\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\CallCentreStatus\Model\CallCentreStatusTable;
use PbxAgi\CallCentreStatus\Model\CallCentreStatus;
use PbxAgi\Conference\Model\Conference;
use PbxAgi\Conference\Model\ConferenceTable;
use Zend\Db\Sql\Select;

class ConferenceTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetrieveAnConferenceByItsConfNumberAndById()
    {
    	$conference = new Conference();
    	$conference->exchangeArray(array(
    	    'id'=> 1,
    	    'confnumber' => '5258',
    	    'ownerref' => 'NULL',
    	    'isprotected' => 0,
    	    'pin' => '',
    	    'lastentered' => NULL,
    	    	    ));
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Conference());
    	$resultSet->initialize(array($conference));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $id = 123;
    	$mockTableGateway->expects($this->any())
    	->method('select')
    	->with(    		
    	    function(Select $select) use ($id) {
    	    	$select->where(array('id' => $id));
    	    	$select->where($this->getFilter());
    	    	$select->limit(1);
    	    }
    	    
    	)
    	->will($this->returnValue($resultSet));
    
    	$conferenceTable = new ConferenceTable($mockTableGateway);
    
    	$conferenceResult = $conferenceTable->getConferenceByConfNumber('5258');
    	$this->assertSame($conference, $conferenceTable->getConferenceByConfNumber('5258')->current());
    	 
    }
    public function testSaveConferenceWillInsertNewConferenceIfTheyDontAlreadyHaveAnId()
    {
    	$conferenceData = array(
    	    'confnumber' => '5258',
    	    'ownerref' => 'NULL',
    	    'isprotected' => 0,
    	    'pin' => '',
    	    'lastentered' => NULL,
    	        	);
    	
    	$conference     = new Conference();
    	$conference->exchangeArray($conferenceData);
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('insert')
    	                 ->with($conferenceData);
    
    	$conferenceTable = new ConferenceTable($mockTableGateway);
    	$lastId = $conferenceTable->saveConference($conference);
    }
    public function testConferenceCanValidateWhenRecordExists()
    {
    	$conference = new Conference();
    	$conference->exchangeArray(array(
    			'id'=> 1,
    			'confnumber' => '5258',
    			'ownerref' => 'NULL',
    			'isprotected' => 0,
    			'pin' => '',
    			'lastentered' => NULL,
    	));
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Conference());
    	$resultSet->initialize(array($conference));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$id = 123;
    	$mockTableGateway->expects($this->any())
    	->method('select')
    	->with(
    			function(Select $select) use ($id) {
    				$select->where(array('id' => $id));
    				$select->where($this->getFilter());
    				$select->limit(1);
    			}
    				
    	)
    	->will($this->returnValue($resultSet));
    
    	$conferenceTable = new ConferenceTable($mockTableGateway);
    
    	$this->assertSame(true, $conferenceTable->isValid('5258'));
    
    }
    public function testConferenceCanReturnFalseOnValidationWhenRecordNotExists()
    {
    
    	$resultSet = new ResultSet();
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$id = 123;
    	$mockTableGateway->expects($this->any())
    	->method('select')
    	->with(
    			function(Select $select) use ($id) {
    				$select->where(array('id' => $id));
    				$select->where($this->getFilter());
    				$select->limit(1);
    			}
    
    	)
    	->will($this->returnValue($resultSet));
    
    	$conferenceTable = new ConferenceTable($mockTableGateway);
    
    	$this->assertSame(false, $conferenceTable->isValid('5258'));
    
    }
    
    	
}