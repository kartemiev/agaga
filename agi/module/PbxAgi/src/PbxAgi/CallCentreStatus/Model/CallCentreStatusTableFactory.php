<?php
namespace PbxAgi\CallCentreStatus\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\CallCentreStatus\Model\CallCentreStatusTable;

class CallCentreStatusTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $tableGateway = $serviceLocator->get('PbxAgi\CallCentreStatus\Model\CallCentreStatusTableGateway');
            $table = new CallCentreStatusTable($tableGateway);
            return $table;
        }     
}