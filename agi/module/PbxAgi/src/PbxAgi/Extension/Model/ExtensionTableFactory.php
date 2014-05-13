<?php
namespace PbxAgi\Extension\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Extension\Model\ExtensionTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $operatortable = $serviceLocator->get('ExtensionTableGateway');
        $instance = new ExtensionTable($operatortable);
        return $instance;
    }
}
