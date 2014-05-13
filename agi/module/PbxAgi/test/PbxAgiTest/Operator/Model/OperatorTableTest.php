<?php
namespace PbxAgiTest\Operator\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\Operator\Model\Operator;
use PbxAgi\Operator\Model\OperatorTable;
 
class OperatorTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetrieveAnOperatorByItsExtension()
    {
        $data = array(		          
		         'extension'=> '100',
		         'extensiontype'=> 'REGULAR',		    
                 'name'=> 'Сидоров',
                 'operatorstatus'=> 'online'            
		    );        
    	$operator = new Operator();
    	$operator->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Operator());
    	$resultSet->initialize(array($operator));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('extension'=>'100'))
    	                 ->will($this->returnValue($resultSet));
    
    	$operatorTable = new OperatorTable($mockTableGateway);
    
    	$this->assertSame($operator, $operatorTable->getOperator('100'));
    }
    public function testCanRetrieveAllOperatorRecords()
    {
    	  $data = array(		          
		         'extension'=> '100',
		         'extensiontype'=> 'REGULAR',		    
                 'name'=> 'Сидоров',
                 'operatorstatus'=> 'online'            
		    );       
    	$operator = new Operator();
    	$operator->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Operator());
    	$resultSet->initialize(array($operator));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with("extensiontype='operator'", function (Select $select)
                            {
                                $select->order('extension ASC');
                            }
		                  )
    	                 ->will($this->returnValue($resultSet));
    
    	$operatorTable = new OperatorTable($mockTableGateway);
    
    	$this->assertSame($resultSet, $operatorTable->fetchAll());
    }
    public function testCanSaveOperator()
    {
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select','update'), array(), '', false);

    	$data = array(
    	        'id'=>1,
    	        'extension'=>'100',
    			'extensiontype'=> 'REGULAR',
    			'name'=> 'Сидоров',
    			'operatorstatus'=> 'online'
    	);
    	$operator = new Operator();
    	$operator->exchangeArray($data);
    	
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Operator());
    	$resultSet->initialize(array($operator));
    	
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('extension' => '100'))
    	                 ->will($this->returnValue($resultSet));
    	 

    	$data = array(
    	        'extension'=>'100',
    			'extensiontype'=> 'REGULAR',
    			'name'=> 'Сидоров',
    			'operatorstatus'=> 'online'
    	);
    	
    	$mockTableGateway->expects($this->once())
    	                 ->method('update')
    	                 ->with($data,array('extension' => '100'))
    	                 ->will($this->returnValue(null));
    
    	$operatorTable = new OperatorTable($mockTableGateway);
    	$operator = new Operator();
    	$operator->exchangeArray($data);
    	$operatorTable->saveOperator($operator);
    }
 }