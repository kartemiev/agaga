<?php
namespace Vpbxui\ExtensionDefaults\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\ExtensionDefaults\Model\ExtensionDefaultsTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionDefaultsTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\ExtensionDefaults\Model\ExtensionDefaultsTableGateway');
        $table = new ExtensionDefaultsTable($tableGateway);
        return $table;
    }
}