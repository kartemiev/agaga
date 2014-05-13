<?php
namespace Vpbxui\CallCentreStatus\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\CallCentreStatus\Model\CallCentreStatus;

class CallCentreStatusTableGatewayFactory implements FactoryInterface
{
 public function createService(ServiceLocatorInterface $serviceLocator)
 {
     $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
     $resultSetPrototype = new ResultSet();
     $resultSetPrototype->setArrayObjectPrototype(new CallCentreStatus());
     return new TableGateway('callcentre_status', $dbAdapter, null, $resultSetPrototype);
 }    
}