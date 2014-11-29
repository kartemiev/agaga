<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\ShortDialFeatureController;

class ShortDialFeatureControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        $mainMenu = $sl->get('PbxAgi\Service\ShortDialMenu\CreateMainMenu');        
        $agi = $sl->get('ClientImpl');
        $cursorContainerInitializer = $sl->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainerInitializer');
        $cursorContainer = $sl->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer');
        return  new ShortDialFeatureController($mainMenu, $agi, $cursorContainerInitializer, $cursorContainer);
    }
}