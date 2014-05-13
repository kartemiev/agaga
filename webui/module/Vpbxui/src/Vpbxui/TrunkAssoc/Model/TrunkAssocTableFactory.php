<?php
namespace Vpbxui\TrunkAssoc\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\TrunkAssoc\Model\TrunkAssocTable;

class TrunkAssocTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('Vpbxui\TrunkAssoc\Model\TrunkAssocTableGateway');
		return new TrunkAssocTable($tableGateway);
	}
}