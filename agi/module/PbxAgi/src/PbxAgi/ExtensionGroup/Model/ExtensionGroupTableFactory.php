<?php
namespace PbxAgi\ExtensionGroup\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\ExtensionGroup\Model\ExtensionGroupTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionGroupTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('PbxAgi\ExtensionGroup\Model\ExtensionGroupTableGateway');
        $table = new ExtensionGroupTable($tableGateway);
        return $table;
    }
}