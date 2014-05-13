<?php
namespace PbxAgi\Route\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Route\Model\RouteTable;
use PbxAgi\NumberMatch\Model\NumberMatchTable;

class RouteTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('PbxAgi\Route\Model\RouteTableGateway');
        $numberMatchTable = $serviceLocator->get('PbxAgi\NumberMatch\Model\NumberMatchTable');
        return new RouteTable($tableGateway, $numberMatchTable);
    }    
}