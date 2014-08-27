<?php
namespace Restful\Controller;

use Zend\ServiceManager\FactoryInterface;
class WizardNumberAllowedControllerFactory implements FactoryInterface
{
	public function createService($serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;	
		return new WizardNumberAllowedController();
	}
}