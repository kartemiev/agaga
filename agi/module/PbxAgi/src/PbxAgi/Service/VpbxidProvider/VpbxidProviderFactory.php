<?php
namespace PbxAgi\Service\VpbxidProvider;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\VpbxidProvider\VpbxidProvider;

class VpbxidProviderFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new VpbxidProvider(
				$serviceLocator->get('CallEntity')
		);
	}
}