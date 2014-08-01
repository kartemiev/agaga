<?php
namespace Saas\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Saas\Controller\PickDidController;

class PickDidControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
 
 		return new PickDidController(
				$sl->get('Saas\FreeDid\Model\FreeDidTable'),
  				$sl->get('Saas\WizardSessionContainer\WizardSessionContainer')
		);
	}
}