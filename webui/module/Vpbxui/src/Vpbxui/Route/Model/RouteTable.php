<?php
namespace Vpbxui\Route\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Vpbxui\Route\Model\Route;
use Vpbxui\Route\Model\RouteTableInterface;

class RouteTable implements RouteTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
     		$select->order('id ASC');
    		});
        $resultSet->buffer();

    	return $resultSet;
    }
    
    public function getRoute($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    
    public function updateDefaultFileldsResetDefault()
    {
        $this->tableGateway
        	 ->update(array('isdefault'=>0));
    }
    
    public function saveRoute(Route $route)
    {
    	$data = array(
    	    'custname' => $route->custname,
    	    'custdesc' => $route->custdesc,
    		'isdefault' => $route->isdefault,
      	);
    	$id = (int)$route->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
    		if ($this->getRoute($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
    
    public function deleteRoute($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
}
