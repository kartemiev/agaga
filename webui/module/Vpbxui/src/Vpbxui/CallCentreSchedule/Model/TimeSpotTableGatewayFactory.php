<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\CallCentreSchedule\Model\TimeSpot; 

class TimeSpotTableGatewayFactory implements FactoryInterface
{
 public function createService(ServiceLocatorInterface $serviceLocator)
 {
     $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
     $resultSetPrototype = new ResultSet();
     $resultSetPrototype->setArrayObjectPrototype(new TimeSpot());
     return new TableGateway('callcentre_time_spots_choice', $dbAdapter, null, $resultSetPrototype);
 }    
}