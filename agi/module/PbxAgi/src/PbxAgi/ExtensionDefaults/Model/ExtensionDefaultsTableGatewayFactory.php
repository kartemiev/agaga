<?php
namespace PbxAgi\ExtensionDefaults\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
use PbxAgi\ExtensionDefaults\Model\ExtensionDefaults;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionDefaultsTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ExtensionDefaults());
        return new TableGateway('extensiondefaults', $dbAdapter, null, $resultSetPrototype);
    }    
}