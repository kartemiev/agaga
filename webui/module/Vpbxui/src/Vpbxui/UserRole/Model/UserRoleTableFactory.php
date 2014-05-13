<?php
namespace Vpbxui\UserRole\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\UserRole\Model\UserRoleTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserRoleTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\UserRole\Model\UserRoleTableGateway');
        return new UserRoleTable($tableGateway);
    }
}