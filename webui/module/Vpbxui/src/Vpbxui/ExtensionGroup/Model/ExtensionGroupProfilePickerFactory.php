<?php
namespace Vpbxui\ExtensionGroup\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\ExtensionGroup\Model\ExtensionGroupProfilePicker;

class ExtensionGroupProfilePickerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $extensionGroupProfileTable = $serviceLocator->get('Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTable');
        return new ExtensionGroupProfilePicker($extensionGroupProfileTable);
    }
}