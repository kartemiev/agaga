<?php
namespace Vpbxui\Roles\Model;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Vpbxui\Roles\Model\Roles;
use Zend\ServiceManager\FactoryInterface;

class RolesTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Roles);
        return new TableGateway('user_role', $dbAdapter, null, $resultSetPrototype);
    }
}