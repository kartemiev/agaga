<?php
namespace Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FaxUserControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		return new FaxUserController(
				$sl->get('Vpbxui\FaxUserEmail\Model\FaxUserEmailTable'),
				$sl->get('Vpbxui\FaxUser\Model\FaxUserTable')
			);
	}
	
}