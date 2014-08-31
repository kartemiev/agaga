<?php
namespace PbxAgi\RegEntry\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use PbxAgi\RegEntry\Model\RegEntry;
use Zend\Db\TableGateway\Feature\FeatureSet;

class RegEntryTableGatewayFactory implements  FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new ResultSet();
 		$resultSetPrototype->setArrayObjectPrototype(new RegEntry());
 		$featureSet = new FeatureSet();
 		$featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
		return new TableGateway('regentries', $dbAdapter, $featureSet, $resultSetPrototype);
	}
}