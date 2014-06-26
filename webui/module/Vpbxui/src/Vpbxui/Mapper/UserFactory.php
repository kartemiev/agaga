<?php
namespace Vpbxui\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Mapper\User;

class UserFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new User(
				$serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidProvider')				
		);
	}
}