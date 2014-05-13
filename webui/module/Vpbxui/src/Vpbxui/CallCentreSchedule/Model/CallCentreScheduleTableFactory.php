<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTable; 

class CallCentreScheduleTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $tableGateway = $serviceLocator->get('Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTableGateway');
            $table = new CallCentreScheduleTable($tableGateway);
            return $table;
        }     
}