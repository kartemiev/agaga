<?php
namespace Vpbxui\Roles\Model;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\Roles\Model\RolesTableInterface;

class RolesTable implements RolesTableInterface
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }       
}