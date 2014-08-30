<?php
namespace Vpbxui\AuthCode\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\AuthCode\Model\AuthCode; 
use Zend\Db\TableGateway\Feature\FeatureSet;

class AuthCodeTableGatewayFactory implements FactoryInterface
{
 public function createService(ServiceLocatorInterface $serviceLocator)
 {
     $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
     $resultSetPrototype = new ResultSet();
     $resultSetPrototype->setArrayObjectPrototype(new AuthCode());
     $featureSet = new FeatureSet();
     $featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
     return new TableGateway('authcodes', $dbAdapter, $featureSet, $resultSetPrototype);
 }    
}
