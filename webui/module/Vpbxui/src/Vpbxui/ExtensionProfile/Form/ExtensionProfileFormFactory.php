<?php
namespace Vpbxui\ExtensionProfile\Form;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\ExtensionProfile\Form\ExtensionProfileForm;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionProfileFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $extensionGroupTable = $serviceLocator->get('Vpbxui\ExtensionGroup\Model\ExtensionGroupTable');  
        $pickupGroupTable = $serviceLocator->get('Vpbxui\PickupGroup\Model\PickupGroupTable');  
        $extensionProfileForm =  new ExtensionProfileForm(null, $extensionGroupTable, $pickupGroupTable);
        return $extensionProfileForm;
    }
}