<?php
namespace Vpbxui\Cdr\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;

class CdrTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator) {
           $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
           $resultSetPrototype = new ResultSet();
           $resultSetPrototype->setArrayObjectPrototype(new Cdr());
           $featureSet = new FeatureSet();
           $featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
           return new TableGateway('cdr', $dbAdapter, $featureSet, $resultSetPrototype);
	}	
}