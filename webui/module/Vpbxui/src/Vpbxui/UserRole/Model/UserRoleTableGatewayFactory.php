<?php
namespace Vpbxui\UserRole\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\UserRole\Model\UserRole;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserRoleTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new UserRole($dbAdapter));
        return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
    }
}