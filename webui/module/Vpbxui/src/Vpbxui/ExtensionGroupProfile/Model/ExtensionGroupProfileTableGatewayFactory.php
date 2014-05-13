<?php
namespace Vpbxui\ExtensionGroupProfile\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfile;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionGroupProfileTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ExtensionGroupProfile());
        return new TableGateway('extensiongroupprofile', $dbAdapter, null, $resultSetPrototype);
    }    
}