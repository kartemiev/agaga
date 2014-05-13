<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildPromptNewAliasNumMenu;

class BuildPromptNewAliasNumMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $newShortDialValidator = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\NewShortDialValidator');
        $createShortDial = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\CreateShortDial');
        $instance = new BuildPromptNewAliasNumMenu($newShortDialValidator, $createShortDial);
        $initializer = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;
    }
}