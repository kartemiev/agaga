<?php
namespace Saas\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class OverviewControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;		
		return new OverviewController(
				$sl->get('Saas\WizardSessionContainer\WizardSessionContainer')
		);
	}
}