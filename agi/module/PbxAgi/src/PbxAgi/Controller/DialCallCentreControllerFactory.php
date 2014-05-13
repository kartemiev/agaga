<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\DialCallCentreController;

class DialCallCentreControllerFactory implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new DialCallCentreController(
              $sl->get('OperatorTable'),
              $sl->get('ClientImpl') ,
              $sl->get('AppConfig'),
        	  $sl->get('PbxAgi\DialDescriptor\DialOptionsDescriptor')
               );
    }
}
