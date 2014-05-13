<?php
namespace PbxAgi\CallDestination\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\CallDestination\Model\CallDestinationTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class CallDestinationTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('PbxAgi\CallDestination\Model\CallDestinationTableGateway');
		return new CallDestinationTable($tableGateway);
	}
}