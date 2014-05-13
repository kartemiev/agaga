<?php
namespace Vpbxui\PbxSettings\Model;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\PbxSettings\Model\PbxSettings;
use Zend\Db\ResultSet\ResultSet;
use Zend\ServiceManager\FactoryInterface;

class PbxSettingsTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new PbxSettings());
        return new TableGateway('pbx_settings', $dbAdapter, null, $resultSetPrototype);
    }
}