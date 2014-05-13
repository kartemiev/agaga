<?php
namespace Vpbxui\UserRole\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\UserRole\Form\UserRoleForm;

class UserRoleFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $rolesTable = $serviceLocator->get('Vpbxui\Roles\Model\RolesTable');
        return  new UserRoleForm(null, $rolesTable);
    }   
}