<?php
namespace PbxAgi\TrunkDestination\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use PbxAgi\TrunkDestination\Model\TrunkDestination;

class TrunkDestinationTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
    	$resultSetPrototype = new ResultSet();
    	$resultSetPrototype->setArrayObjectPrototype(new TrunkDestination());
    	$featureSet = new FeatureSet();
    	$featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
      	return new TableGateway('trunkdestinations', $dbAdapter, null, $resultSetPrototype);        	 
    }
}