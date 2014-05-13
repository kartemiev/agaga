<?php
namespace Vpbxui\ExtensionGroup\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
use Vpbxui\ExtensionGroup\Model\ExtensionGroup;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionGroupTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ExtensionGroup());
        return new TableGateway('extensiongroups', $dbAdapter, null, $resultSetPrototype);
    }    
}