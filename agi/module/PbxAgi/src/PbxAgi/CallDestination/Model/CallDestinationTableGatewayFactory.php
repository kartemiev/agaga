<?php
namespace PbxAgi\CallDestination\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\CallDestination\Model\CallDestination;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;

class CallDestinationTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
    	$resultSetPrototype = new ResultSet();
    	$callDestination = new CallDestination();
    	$resultSetPrototype->setArrayObjectPrototype($callDestination);
    	$featureSet = new FeatureSet();
    	$featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
    	return new TableGateway('call_destination', $dbAdapter, $featureSet, $resultSetPrototype);
    }
}