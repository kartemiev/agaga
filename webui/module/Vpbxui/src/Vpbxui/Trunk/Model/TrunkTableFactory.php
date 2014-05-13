<?php
namespace Vpbxui\Trunk\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Trunk\Model\TrunkTable;

class TrunkTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('Vpbxui\Trunk\Model\TrunkTableGateway');
		return new TrunkTable($tableGateway);
	}
}