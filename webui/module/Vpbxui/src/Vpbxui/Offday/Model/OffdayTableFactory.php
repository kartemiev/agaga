<?php
namespace Vpbxui\Offday\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Offday\Model\OffdayTable;

class OffdayTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
           $tableGateway = $serviceLocator->get('Vpbxui\Offday\Model\OffdayTableGateway');
            $table = new OffdayTable($tableGateway);
            return $table;
    }
}