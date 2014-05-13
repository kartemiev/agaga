<?php
namespace PbxAgi\Service\BuildAbstractMenu;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Service\BuildAbstractMenu\BuildGenericNode;
use Zend\ServiceManager\ServiceLocatorInterface;

class BuildGenericNodeFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appConfig = $serviceLocator->get('AppConfig');
        return new BuildGenericNode($appConfig);
    }
}