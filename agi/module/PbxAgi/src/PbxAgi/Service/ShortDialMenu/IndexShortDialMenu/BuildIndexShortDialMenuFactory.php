<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\BuildIndexShortDialMenu;
class BuildIndexShortDialMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $choiceCurrent = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoiceCurrent');
        $choiceNext = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoiceNext');
        $choicePrevious = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoicePrevious');
        $instance = new BuildIndexShortDialMenu($choiceCurrent, $choiceNext, $choicePrevious);
        $initializer = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;
    }
}