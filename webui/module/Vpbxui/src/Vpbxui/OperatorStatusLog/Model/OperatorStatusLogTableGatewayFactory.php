<?php
namespace Vpbxui\OperatorStatusLog\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\OperatorStatusLog\Model\OperatorStatusLog;
use Zend\Db\TableGateway\Feature\FeatureSet;

class OperatorStatusLogTableGatewayFactory implements FactoryInterface
{
 public function createService(ServiceLocatorInterface $serviceLocator)
 {
     $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
     $resultSetPrototype = new ResultSet();
     $resultSetPrototype->setArrayObjectPrototype(new OperatorStatusLog());
     $featureSet = new FeatureSet();
     $featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
     return new TableGateway('operator_status_log', $dbAdapter, $featureSet, $resultSetPrototype);
 }    
}