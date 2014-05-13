<?php
namespace PbxAgi\Controller;

use PbxAgi\Controller\RecordCallController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RecordCallControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new RecordCallController(
                $sl->get('ClientImpl'),
                $sl->get('AppConfig')
                );
    }
    
}
