<?php
namespace Vpbxui\CallDestination\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\CallDestination\Model\CallDestinationTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class CallDestinationTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('Vpbxui\CallDestination\Model\CallDestinationTableGateway');
		return new CallDestinationTable($tableGateway);
	}
}