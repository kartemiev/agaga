<?php
namespace PbxAgi\Trunk\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Trunk\Model\TrunkTable;

class TrunkTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('PbxAgi\Trunk\Model\TrunkTableGateway');
		return new TrunkTable($tableGateway);
	}
}