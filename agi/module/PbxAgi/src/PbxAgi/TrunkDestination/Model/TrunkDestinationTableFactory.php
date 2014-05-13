<?php
namespace PbxAgi\TrunkDestination\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\TrunkDestination\Model\TrunkDestinationTable;

class TrunkDestinationTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('PbxAgi\TrunkDestination\Model\TrunkDestinationTableGateway');
		return new TrunkDestinationTable($tableGateway);
	}
}