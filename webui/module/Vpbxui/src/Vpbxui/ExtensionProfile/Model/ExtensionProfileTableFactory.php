<?php
namespace Vpbxui\ExtensionProfile\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\ExtensionProfile\Model\ExtensionProfileTable;

class ExtensionProfileTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\ExtensionProfile\Model\ExtensionProfileTableGateway');
        return new ExtensionProfileTable($tableGateway);
    }    
}