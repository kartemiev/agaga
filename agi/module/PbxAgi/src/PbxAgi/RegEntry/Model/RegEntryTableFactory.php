<?php
namespace PbxAgi\RegEntry\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\RegEntry\Model\RegEntryTable; 

class RegEntryTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('PbxAgi\RegEntry\Model\RegEntryTableGateway');
		return new RegEntryTable($tableGateway);
	}
}