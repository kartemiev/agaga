<?php
namespace PbxAgi\Route\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use PbxAgi\Route\Model\Route;
use PbxAgi\Route\Model\RouteTableInterface;
 
class RouteTable implements RouteTableInterface {

    protected $tableGateway;
     public function __construct(TableGateway $tableGateway)
     {
    	$this->tableGateway = $tableGateway;
     }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway
    					  ->select(function (Select $select) {
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
}
