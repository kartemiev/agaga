<?php
namespace PbxAgi\Ivr\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Ivr\Model\Ivr;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\FeatureSet;

class IvrTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new Ivr());
		$featureSet = new FeatureSet();
		$featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
		return new TableGateway('ivr', $dbAdapter, $featureSet, $resultSetPrototype);
	}
}