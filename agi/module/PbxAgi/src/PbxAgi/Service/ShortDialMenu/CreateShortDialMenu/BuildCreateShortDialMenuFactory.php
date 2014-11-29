<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildCreateShortDialMenu;

class BuildCreateShortDialMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $instance = new BuildCreateShortDialMenu($newShortDateValidator, $shortDialNumChosen);
        $initializer = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer');
        $initializer->initialize($instance, $serviceLocator);
        $instance->setChoiceCurrent($serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoiceCurrent'));
        return $instance;
        
    }
}