<?php
namespace PbxAgiTest\FaxUser\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\FaxUser\Model\FaxUserTable;
use PbxAgi\FaxUser\Model\FaxUser;

class FaxUserTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetrieveAFaxUserByItsEmail()
    {
        $data = array(
        		'id'=>1,
        		'custname'=> 'Иванов Иван Иванович',
        		'email'=> 'ivanivanov@example.local'
        );
        
    	$faxuser = new FaxUser();
    	$faxuser->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new FaxUser());
    	$resultSet->initialize(array($faxuser));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $email = 'ivanivanov@example.local';
    	$mockTableGateway->expects($this->once())
    	->method('select')
    	->with(function(Select $select) use ($email) 
    			{
    				$select->where(array('email' => $email));
    				$select->limit(1);
    			})
    	->will($this->returnValue($resultSet));
    
    	$faxUserTable = new FaxUserTable($mockTableGateway);
    
    	$this->assertSame($faxuser, $faxUserTable->getFaxUserByEmail($email));
    }
    
 }