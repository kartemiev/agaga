<?php
namespace Vpbxui\Route\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Route\Model\RouteTable;

class RouteTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\Route\Model\RouteTableGateway');
        return new RouteTable($tableGateway);
    }    
}