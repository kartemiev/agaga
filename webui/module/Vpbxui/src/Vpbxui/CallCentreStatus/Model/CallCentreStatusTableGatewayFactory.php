<?php
namespace Vpbxui\CallCentreStatus\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\CallCentreStatus\Model\CallCentreStatus;
use Zend\Db\TableGateway\Feature\FeatureSet;

class CallCentreStatusTableGatewayFactory implements FactoryInterface
{
 public function createService(ServiceLocatorInterface $serviceLocator)
 {
     $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
     $resultSetPrototype = new ResultSet();
     $resultSetPrototype->setArrayObjectPrototype(new CallCentreStatus());
     $featureSet = new FeatureSet();
     $featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
     return new TableGateway('callcentre_status', $dbAdapter, $featureSet, $resultSetPrototype);
 }    
}