<?php
namespace PbxAgi\Service\ShortDialMenu\MainMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class BuildMainMenuFactory implements FactoryInterface 
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $instance = new BuildMainMenu();
        $initializer = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;
    }
}