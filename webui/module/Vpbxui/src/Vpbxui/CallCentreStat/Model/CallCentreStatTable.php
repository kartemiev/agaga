<?php
namespace Vpbxui\CallCentreStat\Model;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\CallCentreStat\Model\CallCentreStatTableInterface;
use Zend\Db\Sql\Select;

class CallCentreStatTable implements CallCentreStatTableInterface
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
          	$resultSet = $this->tableGateway->select($filter,function (Select $select) {
    });
            $resultSet->buffer();

    	return $resultSet;
    }     
}