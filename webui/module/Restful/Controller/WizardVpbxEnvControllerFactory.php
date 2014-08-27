<?php
namespace Restful\Controller;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WizardVpbxEnvControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		
		return new VpbxEnv(
				$sl->get('Saas\FreeDid\Model\FreeDidTable'),
				$sl->get('Saas\WizardSessionContainer\WizardSessionContainer')
		);
 	}
}