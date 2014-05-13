<?php
namespace Vpbxui\UserRole\Model;

use Vpbxui\UserRole\Model\UserRoleTableInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class UserRoleTable implements UserRoleTableInterface
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->order('username ASC');
            $select->join('user_role', 'user.role = user_role.role_id', array('description'));
            
        });
        $resultSet->buffer();
    
        return $resultSet;
    }
    
    public function getUserRole($user_id)
    {
        $user_id  = (int) $user_id;
        $rowset = $this->tableGateway->select(array('user_id' => $user_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $user_id");
        }
        return $row;
    }
        
    public function saveUserRole(UserRole $userRole)
    {
    
        $data = array(
            'role' => $userRole->role,
        );
        $user_id = (int)$userRole->user_id;
        if ($user_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUserRole($user_id)) {
                $this->tableGateway->update($data, array('user_id' => $user_id));
            } else {
                throw new \Exception('Form user_id does not exist');
            }
        }
    }        
}
