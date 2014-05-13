<?php
namespace Vpbxui\FreeExtension\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class FreeExtensionTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $freeExtension = $serviceLocator->get('Vpbxui\FreeExtension\Model\FreeExtension');
        $resultSetPrototype->setArrayObjectPrototype($freeExtension);
        return new TableGateway('sip_free_extensions', $dbAdapter, null, $resultSetPrototype);
    }
}