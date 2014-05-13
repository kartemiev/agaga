<?php
namespace Vpbxui\OperatorStatusLog\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTable;

class OperatorStatusLogTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            return new OperatorStatusLogTable(
                $serviceLocator->get('Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTableGateway')
                );
        }     
}