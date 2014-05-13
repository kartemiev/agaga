<?php
namespace PbxAgi\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\Plugin\RedirectorControllerPlugin;

class RedirectorControllerPluginFactory implements FactoryInterface{

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new RedirectorControllerPlugin(
                $sl->get('Router')
                );
    }
}