<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\AlarmPlayController;

class AlarmPlayControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		return new AlarmPlayController(
		      $sl->get('ClientImpl'),
		      $sl->get('PbxAgi\GenericWrappers\DateTime')		    
            );		
	}
}