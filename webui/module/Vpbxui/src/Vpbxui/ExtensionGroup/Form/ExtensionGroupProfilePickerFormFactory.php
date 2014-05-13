<?php
namespace Vpbxui\ExtensionGroup\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\ExtensionGroup\Form\ExtensionGroupProfilePickerForm;

class ExtensionGroupProfilePickerFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $extensionGroupProfileTable = $serviceLocator->get('Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTable');
        return  new ExtensionGroupProfilePickerForm(null, $extensionGroupProfileTable);
    }
}