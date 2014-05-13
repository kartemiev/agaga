<?php
namespace Vpbxui\Offday\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\Offday\Model\Offday;
use Zend\Db\ResultSet\HydratingResultSet;

class OffdayTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new HydratingResultSet();
        $resultSetPrototype->setObjectPrototype(new Offday());
        return new TableGateway('schedule_replacements', $dbAdapter, null, $resultSetPrototype);
    }
}