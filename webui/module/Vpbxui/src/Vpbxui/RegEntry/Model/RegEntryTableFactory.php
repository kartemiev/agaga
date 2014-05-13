<?php
namespace Vpbxui\RegEntry\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\RegEntry\Model\RegEntryTable; 

class RegEntryTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('Vpbxui\RegEntry\Model\RegEntryTableGateway');
		return new RegEntryTable($tableGateway);
	}
}