<?php
namespace Vpbxui\Role\Model;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Vpbxui\Role\Model\Role;

class RoleTableGatewayFactory
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Role());
        return new TableGateway('user_role_linker', $dbAdapter, null, $resultSetPrototype);
    }
}