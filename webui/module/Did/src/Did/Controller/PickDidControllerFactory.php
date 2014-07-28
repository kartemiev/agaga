<?php
namespace Did\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Did\Controller\PickDidController;

class PickDidControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
 
 		return new PickDidController(
				$sl->get('Did\FreeDid\Model\FreeDidTable')
		);
	}
}