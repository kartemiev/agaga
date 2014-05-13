<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\CallCentreSchedule\Model\CallCentreSchedule;

class CallCentreScheduleTableGatewayFactory implements FactoryInterface
{
 public function createService(ServiceLocatorInterface $serviceLocator)
 {
     $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
     $resultSetPrototype = new ResultSet();
     $resultSetPrototype->setArrayObjectPrototype(new CallCentreSchedule());
     return new TableGateway('callcentre_working_schedule', $dbAdapter, null, $resultSetPrototype);
 }    
}