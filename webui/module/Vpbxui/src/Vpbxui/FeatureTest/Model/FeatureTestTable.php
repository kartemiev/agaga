<?php
namespace Vpbxui\FeatureTest\Model;


use Vpbxui\FeatureTest\Model\FeatureTest;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class FeatureTestTable {

    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
     		});
    	     
         $resultSet->buffer();
 		
    	return $resultSet;
    }
    
    public function getFeatureTest($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(function ($select) use ($id) {
    	    $select->where(array('id'=>$id));    	    	
    	});
     	
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    
    public function saveFeatureTest(FeatureTest $featureTest)
    {
        
    	$data = array(
    	    'test1'=>$featureTest->test1,
    	    'test2'=>$featureTest->test2,
    	    'test3'=>$featureTest->test3
        	);
     
      	$id = (int)$featureTest->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
    		if ($this->getFeatureTest($id)) {
     			$this->tableGateway->update($data,array('id'=>$id));     			
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
    
    public function deleteFeatureSet($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
 }