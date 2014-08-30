<?php
namespace Vpbxui\RegEntry\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\RegEntry\Model\RegEntry;
use Zend\Db\TableGateway\Feature\FeatureSet;

class RegEntryTableGatewayFactory implements  FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new ResultSet();
 		$resultSetPrototype->setArrayObjectPrototype(new RegEntry());
 		$featureSet = new FeatureSet();
 		$featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature')); 		
		return new TableGateway('regentries', $dbAdapter, null, $resultSetPrototype);
	}
}