<?php
namespace PbxAgi\Service\ShortDialMenu\GotoShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\BuildGotoShortDialMenu;

class BuildGotoShortDialMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator){
        $shiftCursor = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\ShiftCursor');
        $existingShortDialValidator = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\ExistingShortDialValidator');
        $instance = new BuildGotoShortDialMenu($shiftCursor, $existingShortDialValidator);
        $initializer = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;
    }
}