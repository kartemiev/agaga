<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoiceNext;

class ChoiceNextFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $instance = new ChoiceNext();
        $initializer = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\AbstractCursorChoiceInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;
    }
}