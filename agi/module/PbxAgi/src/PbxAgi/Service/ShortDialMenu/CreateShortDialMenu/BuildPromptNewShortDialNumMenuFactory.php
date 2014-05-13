<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildPromptNewShortDialNumMenu;

class BuildPromptNewShortDialNumMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $newShortDateValidator = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\NewShortDialValidator');        
        $shortDialNumChosen = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\ShortDialNumChosen');
        $instance = new BuildPromptNewShortDialNumMenu($newShortDateValidator, $shortDialNumChosen);
        $initializer = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;
        
    }
}