<?php
namespace Vpbxui\Extension\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Extension\Model\ExtensionProfilePicker;

class ExtensionProfilePickerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $extensionProfileTable = $serviceLocator->get('Vpbxui\ExtensionProfile\Model\ExtensionProfileTable');
        return new ExtensionProfilePicker($extensionProfileTable);
    }
}