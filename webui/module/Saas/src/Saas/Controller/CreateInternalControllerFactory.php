<?php
namespace Saas\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class CreateInternalControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		
		return new CreateInternalController(
				$sl->get('Saas\WizardSessionContainer\WizardSessionContainer'),
				$sl->get('Vpbxui\Extension\Model\Extension'),	
				$sl->get('Vpbxui\Extension\Form\ExtensionForm')			
		);
	}
}