<?php
namespace Vpbxui\Extension\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Extension\Form\ExtensionProfilePickerForm;

class ExtensionProfilePickerFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $extensionProfileTable = $serviceLocator->get('Vpbxui\ExtensionProfile\Model\ExtensionProfileTable');
        return  new ExtensionProfilePickerForm(null, $extensionProfileTable);
    }
}
