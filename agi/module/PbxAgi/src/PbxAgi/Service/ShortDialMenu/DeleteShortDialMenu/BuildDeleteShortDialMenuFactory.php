<?php
namespace PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BuildDeleteShortDialMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $deleteShortDial = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu\DeleteShortDial');        
        $instance = new BuildDeleteShortDialMenu($deleteShortDial);
        $initializer = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;
    }
}