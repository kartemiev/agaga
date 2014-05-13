<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainerInitializer;

class CursorContainerInitializerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $call = $serviceLocator->get('CallEntity');
        $shortDialTable = $serviceLocator->get('PbxAgi\ShortDial\Model\ShortDialTable');
        return new CursorContainerInitializer($call, $shortDialTable);
    }
}