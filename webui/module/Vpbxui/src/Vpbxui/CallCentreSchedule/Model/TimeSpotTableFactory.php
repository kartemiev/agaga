<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\CallCentreSchedule\Model\TimeSpotTable; 

class TimeSpotTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
             return new TimeSpotTable(
             		$serviceLocator->get('Vpbxui\CallCentreSchedule\Model\TimeSpotTableGateway')
			);
        }     
}