<?php
namespace Vpbxui\Context\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Context\Model\Context;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;

class ContextTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new ResultSet();
 		$resultSetPrototype->setArrayObjectPrototype($serviceLocator->get('Vpbxui\Context\Model\Context'));
 		$featureSet = new FeatureSet();
 		$featureSet->addFeature(new SequenceFeature('id','context_id_seq'));
		return new TableGateway('context', $dbAdapter, $featureSet, $resultSetPrototype);
		
	}
}