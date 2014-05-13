<?php
namespace Vpbxui\PickupGroup\Model;

use Vpbxui\PickupGroup\Model\PickupGroup;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class PickupGroupTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select($filter,function (Select $select) {
     $select->order('custname ASC');
    });
            $resultSet->buffer();

    	return $resultSet;
    }
    
    public function getPickupGroup($name)
    {
    	$rowset = $this->tableGateway->select(array('name' => $name));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $name");
    	}
     	return $row;
    }
    
    public function savePickupGroup(PickupGroup $pickupGroup)
    {
        
    	$data = array(
    			'custname' => $pickupGroup->custname,
    	       'description' => $pickupGroup->description,    	    	
    	);
    	$name = $pickupGroup->name;
    	if (!$name) {
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getPickupGroup($name)) {
    			$this->tableGateway->update($data, array('name' => $name));
    		} else {
    			throw new \Exception('Form name does not exist');
    		}
    	}
    }
    
    public function deletePickupGroup($name)
    {
    	$this->tableGateway->delete(array('name' => $name));
    }
   
}
