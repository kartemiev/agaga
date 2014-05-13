<?php
namespace Vpbxui\CallCentreStat\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\CallCentreStat\Model\CallCentreStatTable;

class CallCentreStatTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $tableGateway = $serviceLocator->get('Vpbxui\CallCentreStat\Model\CallCentreStatTableGateway');
            $table = new CallCentreStatTable($tableGateway);
            return $table;
        }     
}