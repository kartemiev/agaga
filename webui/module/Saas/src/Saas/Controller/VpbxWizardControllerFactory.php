<?php
namespace Saas\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VpbxWizardControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		$wizardSessionContainer = $sl->get('Saas\WizardSessionContainer\WizardSessionContainer');		
		return new VpbxWizardController($wizardSessionContainer);
	}
}