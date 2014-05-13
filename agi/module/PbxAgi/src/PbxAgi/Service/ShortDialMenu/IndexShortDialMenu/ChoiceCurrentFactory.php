<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoiceCurrent;

class ChoiceCurrentFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $instance = new ChoiceCurrent();
        $initializer = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\AbstractCursorChoiceInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;
    }
}