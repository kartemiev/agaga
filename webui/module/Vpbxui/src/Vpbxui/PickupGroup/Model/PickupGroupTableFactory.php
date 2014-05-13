<?php
namespace Vpbxui\PickupGroup\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\PickupGroup\Model\PickupGroupTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class PickupGroupTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\PickupGroup\Model\PickupGroupTableGateway');
        $table = new PickupGroupTable($tableGateway);
        return $table;
    }
}