<?php
namespace Vpbxui\Role\Model;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\Role\Model\RoleTableInterface;

class RoleTable implements RoleTableInterface
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($user_id)
    {
        $resultSet = $this->tableGateway->select(array('user_id'=>$user_id));
        return $resultSet;
    } 
    public function addAcl($userId, $roleName)
    {
        $data = array(
            'user_id' => $userId,
            'role_id' => $roleName
        );        
        $this->tableGateway->insert($data);                 
    }
    public function removeAcl($userId, $roleName)
    {
        $resultSet = $this->tableGateway->delete( array('user_id' => $userId, 'role_id' => $roleName) );
    }
    
}