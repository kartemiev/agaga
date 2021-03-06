<?php
namespace Vpbxui\Trunk\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use Vpbxui\Trunk\Model\Trunk;

class TrunkTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
    	$resultSetPrototype = new ResultSet();
    	$resultSetPrototype->setArrayObjectPrototype(new Trunk());
    	$featureSet = new FeatureSet();
    	$featureSet->addFeature(new SequenceFeature('id','sip_serial'));
    	$featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
    	return new TableGateway('sip', $dbAdapter, $featureSet, $resultSetPrototype);        	 
    }
}