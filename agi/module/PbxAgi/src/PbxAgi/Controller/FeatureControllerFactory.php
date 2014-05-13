<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\FeatureController; 

class FeatureControllerFactory implements FactoryInterface {
    
	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    $sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
         return new FeatureController(
                $sl->get('AppConfig'), 
                $sl->get('ChannelVarManager'), 
         		$sl->get('PbxAgi\Feature\Model\FeatureTable')             
                );
	}
}
