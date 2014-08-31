<?php
namespace PbxAgi\RecordedCall\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;

class RecordedCallTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator) {
           $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
           $resultSetPrototype = new ResultSet();
           $resultSetPrototype->setArrayObjectPrototype(new RecordedCall());
           $featureSet = new FeatureSet();
           $featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
           return new TableGateway('RecordedCall', $dbAdapter, $featureSet, $resultSetPrototype);
	}	
}