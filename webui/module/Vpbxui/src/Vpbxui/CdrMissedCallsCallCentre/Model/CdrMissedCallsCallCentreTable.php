<?php
namespace Vpbxui\CdrMissedCallsCallCentre\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CdrMissedCallsCallCentreTable
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($filter) {
            $select->order('calldate ASC');
            $select->where($filter);
        });
        $resultSet->buffer();
    
        return $resultSet;
    }
    
    public function getCdrMissedCallsCallCentre($id)
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