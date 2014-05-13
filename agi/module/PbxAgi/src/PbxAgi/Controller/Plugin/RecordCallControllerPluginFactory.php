<?php
namespace PbxAgi\Controller\Plugin;

use PbxAgi\Controller\Plugin\RecordCallControllerPlugin;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class RecordCallControllerPluginFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new RecordCallControllerPlugin(
                $sl->get('ClientImpl'),
                $sl->get('AppConfig')
                );
    }
    
}
