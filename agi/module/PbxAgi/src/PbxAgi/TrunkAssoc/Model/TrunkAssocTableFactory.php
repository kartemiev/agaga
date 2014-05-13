<?php
namespace PbxAgi\TrunkAssoc\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\TrunkAssoc\Model\TrunkAssocTable;

class TrunkAssocTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('PbxAgi\TrunkAssoc\Model\TrunkAssocTableGateway');
		return new TrunkAssocTable($tableGateway);
	}
}