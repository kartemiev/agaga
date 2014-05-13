<?php
namespace Vpbxui\ExtensionProfile\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ExtensionProfileTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $extension = $serviceLocator->get('Vpbxui\ExtensionProfile\Model\ExtensionProfile');
        $resultSetPrototype->setArrayObjectPrototype($extension);
        return new TableGateway('extensionprofile', $dbAdapter, null, $resultSetPrototype);
    }
}