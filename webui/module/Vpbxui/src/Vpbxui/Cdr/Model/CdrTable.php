<?php
namespace Vpbxui\Cdr\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class CdrTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($select, $filter,$orderseq)
    {
     	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter,$orderseq) {
         $select->where($filter);     
       $select->order($orderseq);
     });
            $resultSet->buffer();

    	return $resultSet;
    }
    
       public function getCdr($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    } 
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}
