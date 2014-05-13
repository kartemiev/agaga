<?php
namespace Vpbxui\OperatorStat\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\OperatorStat\Model\OperatorStat;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class OperatorStatTableGatewayFactory implements FactoryInterface
{
 public function createService(ServiceLocatorInterface $serviceLocator)
 {
     $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
     $resultSetPrototype = new ResultSet();
     $resultSetPrototype->setArrayObjectPrototype(new OperatorStat());
     return new TableGateway('cdr_callcentre_operator_stat', $dbAdapter, null, $resultSetPrototype);
 }    
}