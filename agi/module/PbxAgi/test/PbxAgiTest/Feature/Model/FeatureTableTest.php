<?php
namespace PbxAgiTest\FaxUser\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\Feature\Model\Feature;
use PbxAgi\Feature\Model\FeatureTable;

class FeatureTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetrieveAFeatureByItsId()
    {
        $data = array(
        		'id'=>1,
        		'custname'=> 'телеконференция',
        		'custdesc'=> ''
        );
        
    	$feature = new Feature();
    	$feature->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Feature());
    	$resultSet->initialize(array($feature));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('id'=>1))
    	                 ->will($this->returnValue($resultSet));
    
    	$featureTable = new FeatureTable($mockTableGateway);
    
    	$this->assertSame($feature, $featureTable->getFeature(1));
    }
    public function testGetFeatureByItsIdThrowsAnExceptionOnNonexistantFeature()
    {
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Feature());
    	$resultSet->initialize(array());
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('id'=>1))
    	                 ->will($this->returnValue($resultSet));
    
    	$featureTable = new FeatureTable($mockTableGateway);
    	try
    	{
    		$featureTable->getFeature(1);
    	}
    	catch (\Exception $e)
    	{
    		$this->assertSame("Could not find row 1", $e->getMessage());
    		return;
    	}
    	
    	$this->fail('Expected exception was not thrown');
    	
    }
    
    public function testCanReturnAllFeatures()
    {
        $data = array(
        		'id'=>1,
        		'custname'=> 'телеконференция',
        		'custdesc'=> ''
        );
        
        $feature = new Feature();
        $feature->exchangeArray($data);
        
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Feature());
        $resultSet->initialize(array($feature));
        
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with()
                         ->will($this->returnValue($resultSet));
        
        $featureTable = new FeatureTable($mockTableGateway);
        
        $this->assertSame($resultSet, $featureTable->fetchAll());
        
    }
    
 }