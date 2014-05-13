<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildConfirmSaveShortDialMenu;

class BuildConfirmSaveShortDialMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $createShortDial = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\CreateShortDial');
        $newShortDialValidator = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\NewShortDialValidator');
        $instance = new BuildConfirmSaveShortDialMenu($createShortDial, $newShortDialValidator);
        $initializer = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;        
     }    
}