<?php
namespace Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Controller\RegisterPbxController;

class RegisterPbxControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		return new RegisterPbxController(
				$sl->get('zfcuser_register_form'),
				$sl->get('zfcuser_user_service'),
				$sl->get('zfcuser_module_options'),
				$sl->get('Vpbxui\PbxSettings\Model\PbxSettingsTable')
				);
	}
}