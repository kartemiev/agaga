<?php
namespace Vpbxui\OperatorStat\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\OperatorStat\Model\OperatorStat;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;

class OperatorStatTableGatewayFactory implements FactoryInterface
{
 public function createService(ServiceLocatorInterface $serviceLocator)
 {
     $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
     $resultSetPrototype = new ResultSet();
     $resultSetPrototype->setArrayObjectPrototype(new OperatorStat());
     $featureSet = new FeatureSet();
     $featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidProvider'));
     return new TableGateway('cdr_callcentre_operator_stat', $dbAdapter, $featureSet, $resultSetPrototype);
 }    
}