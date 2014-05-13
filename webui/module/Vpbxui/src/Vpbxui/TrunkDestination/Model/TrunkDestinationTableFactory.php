<?php
namespace Vpbxui\TrunkDestination\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\TrunkDestination\Model\TrunkDestinationTable;

class TrunkDestinationTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('Vpbxui\TrunkDestination\Model\TrunkDestinationTableGateway');
		return new TrunkDestinationTable($tableGateway);
	}
}