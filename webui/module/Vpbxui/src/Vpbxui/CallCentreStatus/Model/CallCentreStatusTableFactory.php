<?php
namespace Vpbxui\CallCentreStatus\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\CallCentreStatus\Model\CallCentreStatusTable;

class CallCentreStatusTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $tableGateway = $serviceLocator->get('Vpbxui\CallCentreStatus\Model\CallCentreStatusTableGateway');
            $table = new CallCentreStatusTable($tableGateway);
            return $table;
        }     
}