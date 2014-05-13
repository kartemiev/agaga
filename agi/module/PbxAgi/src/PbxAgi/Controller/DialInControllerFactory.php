<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Controller\DialInController;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class DialInControllerFactory implements FactoryInterface {
    
	public function createService(ServiceLocatorInterface $serviceLocator) {
	    $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
         return new DialInController(
                $sl->get('AppConfig'), 
                $sl->get('ClientImpl'),
                $sl->get('ExtensionRegexValidator'),
                $sl->get('ChannelVarManager'),
         		$sl->get('PbxAgi\DialDescriptor\DialOptionsDescriptor')              
                );
	}
}
