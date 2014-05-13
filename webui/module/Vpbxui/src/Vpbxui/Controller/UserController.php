<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\Role\Model\RoleTableInterface;
use Vpbxui\Roles\Model\RolesTableInterface;

class UserController extends AbstractActionController
{
    protected $roleTable;
    protected $rolesTable;
    public function __construct(
        RoleTableInterface $roleTable,
        RolesTableInterface $rolesTable)
    {
        $this->roleTable = $roleTable;
        $this->rolesTable = $rolesTable;
    }
    public function listactiverolesAction()
    {
        $userId = $this->params('userId');
        $roles = $this->roleTable->fetchAll($userId);
        return new ViewModel(
            array(
                'roles'=>$roles                
        )
            );
    }
    
    public function listavailablerolesAction()
    {
        $roles = $this->rolesTable->fetchAll();
        return new ViewModel(
            array(
                'roles'=>$roles
            )
        );
    }
    
    public function removeaclAction()
    {
        $userId = $this->params('userId');
        $role = $this->params('role');
        $roles = $this->roleTable->removeAcl($userId,$role);
        return $this->redirect()->toRoute('vpbxui/users/listacls',array('action' => 'listacls','id' => $userId));
    }
    public function addaclAction()
    {
        $userId = $this->params('userId');
        $role = $this->params('role');
        $roles = $this->roleTable->addAcl($userId,$role);
        return $this->redirect()->toRoute('vpbxui/users/listacls',array('action' => 'listacls','id' => $userId));
    }
}
 