<?php
namespace Saas\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateVpbxEnvControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		return new CreateVpbxEnvController(
				$sl->get('Vpbxui\Extension\Model\ExtensionTable'),
		        $sl->get('Saas\WizardSessionContainer\WizardSessionContainer')
		);
	}
}