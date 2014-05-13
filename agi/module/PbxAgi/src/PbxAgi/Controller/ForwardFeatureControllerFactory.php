<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Controller\ForwardFeatureController;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForwardFeatureControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl =(method_exists($serviceLocator, 'getServiceLocator')) ? 
                $serviceLocator->getServiceLocator():
            $serviceLocator;        
        return new ForwardFeatureController(
                $sl->get('ExtensionTable'),
                $sl->get('AppConfig'), 
                $sl->get('ClientImpl'),
                $sl->get('CallEntity')
                );
    }
}
 