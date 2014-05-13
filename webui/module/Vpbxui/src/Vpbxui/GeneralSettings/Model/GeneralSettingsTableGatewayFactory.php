<?php
namespace Vpbxui\GeneralSettings\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\GeneralSettings\Model\GeneralSettings;

class GeneralSettingsTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {         
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new GeneralSettings());
        return new TableGateway('pbx_settings', $dbAdapter, null, $resultSetPrototype);
    }    
}