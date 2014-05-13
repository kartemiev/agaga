<?php
namespace Vpbxui\TrunkAssoc\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\TrunkAssoc\Model\TrunkAssoc;

class TrunkAssocTableGatewayFactory implements  FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new ResultSet();
		$trunkAssoc = new TrunkAssoc();
		$resultSetPrototype->setArrayObjectPrototype($trunkAssoc);
		return new TableGateway('trunkassoc', $dbAdapter, null, $resultSetPrototype);
	}
}