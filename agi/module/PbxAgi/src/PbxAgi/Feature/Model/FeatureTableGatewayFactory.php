<?php
namespace PbxAgi\Feature\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Feature\Model\Feature;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class FeatureTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new ResultSet();
 		$resultSetPrototype->setArrayObjectPrototype(new Feature());
		return new TableGateway('functions', $dbAdapter, null, $resultSetPrototype);
		
	}
}