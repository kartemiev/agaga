<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\ShortDialFeatureController;

class ShortDialFeatureControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mainMenu = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateMainMenu');        
        $agi = $serviceLocator->get('ClientImpl');
        $cursorContainerInitializer = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainerInitializer');
        $cursorContainer = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer');
        return  new ShortDialFeatureController($mainMenu, $agi, $cursorContainerInitializer, $cursorContainer);
    }
}