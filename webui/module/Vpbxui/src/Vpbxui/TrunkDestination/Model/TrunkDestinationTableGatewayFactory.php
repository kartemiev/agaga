<?php
namespace Vpbxui\TrunkDestination\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use Vpbxui\TrunkDestination\Model\TrunkDestination;

class TrunkDestinationTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
    	$resultSetPrototype = new ResultSet();
    	$resultSetPrototype->setArrayObjectPrototype(new TrunkDestination());
    	$featureSet = new FeatureSet();
    	$featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
      	return new TableGateway('trunkdestinations', $dbAdapter, $featureSet, $resultSetPrototype);        	 
    }
}