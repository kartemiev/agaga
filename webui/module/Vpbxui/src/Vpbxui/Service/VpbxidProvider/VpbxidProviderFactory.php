<?php
namespace Vpbxui\Service\VpbxidProvider;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Service\VpbxidProvider\VpbxidProvider;

class VpbxidProviderFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new VpbxidProvider(
				$serviceLocator->get('zfcuser_auth_service')
		);
	}
}