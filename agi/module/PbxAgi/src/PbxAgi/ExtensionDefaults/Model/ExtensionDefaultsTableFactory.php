<?php
namespace PbxAgi\ExtensionDefaults\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionDefaultsTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTableGateway');
        $table = new ExtensionDefaultsTable($tableGateway);
        return $table;
    }
}