<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\CallCentreSchedule\Model\TimeSpotTable; 

class TimeSpotTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $tableGateway = $serviceLocator->get('Vpbxui\CallCentreSchedule\Model\TimeSpotTableGateway');
            $table = new TimeSpotTable($tableGateway);
            return $table;
        }     
}