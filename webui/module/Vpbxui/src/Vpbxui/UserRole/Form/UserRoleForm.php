<?php
namespace Vpbxui\UserRole\Form;

use Zend\Form\Form;
use Vpbxui\Roles\Model\RolesTableInterface;

class UserRoleForm extends Form
{
    protected $rolesTable;
    public function __construct($name = null, RolesTableInterface $rolesTable)
    {
        // we want to ignore the name passed
        parent::__construct('userroles');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
    
        $this->rolesTable = $rolesTable;
        
        $rolesOptions = $this->getRolesOptions();
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'role',
            'attributes' =>  array(
                'id' => 'role',
                'options' => $rolesOptions,
            ),
            'options' => array(
                'label' => 'роль',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));         
         
    }
    protected function getRolesOptions()
    {
        $roles = $this->rolesTable->fetchAll();
        
        $rolesOptions=[];
        foreach ($roles as $role)
        {
            $rolesOptions[$role->role_id] = $role->description;
        }
        return $rolesOptions;
        
    }
}