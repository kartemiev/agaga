<?php
namespace Vpbxui\Extension\Form;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Extension\Form\ExtensionForm;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $extensionGroupTable = $serviceLocator->get('Vpbxui\ExtensionGroup\Model\ExtensionGroupTable');  
        $pickupGroupTable = $serviceLocator->get('Vpbxui\PickupGroup\Model\PickupGroupTable');  
        $extensionTable = $serviceLocator->get('Vpbxui\Extension\Model\ExtensionTable');   
        $freeExtensionTable = $serviceLocator->get('Vpbxui\FreeExtension\Model\FreeExtensionTable');
        $callDestinationTable = $serviceLocator->get('Vpbxui\CallDestination\Model\CallDestinationTable');
		$routeTable = $serviceLocator->get('Vpbxui\Route\Model\RouteTable');
        $extensionForm =  new ExtensionForm(null, 
        		$extensionGroupTable, 
        		$pickupGroupTable, 
        		$extensionTable, 
        		$freeExtensionTable,
        		$callDestinationTable,
        		$routeTable
		);
          return $extensionForm;
    }
}