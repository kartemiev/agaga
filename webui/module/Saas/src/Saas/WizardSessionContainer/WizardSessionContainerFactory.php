<?php
namespace Saas\WizardSessionContainer;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container as SessionContainer;

class WizardSessionContainerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new SessionContainer('vpbx_wizard');
	}
}