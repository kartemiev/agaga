<?php
namespace PbxAgi\Trunk\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use PbxAgi\Trunk\Model\Trunk;

class TrunkTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
    	$resultSetPrototype = new ResultSet();
    	$resultSetPrototype->setArrayObjectPrototype(new Trunk());
    	$featureSet = new FeatureSet();
    	$featureSet->addFeature('PbxAgi\Service\VpbxidProvider\VpbxidFeature');
    	return new TableGateway('sip', $dbAdapter, $featureSet, $resultSetPrototype);        	 
    }
}