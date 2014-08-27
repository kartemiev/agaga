<?php
namespace Restful\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class WizardFreeControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		
		return new WizardFreeDidController(
				$sl->get('Saas\FreeDid\Model\FreeDidTable')
 		);
	}
}