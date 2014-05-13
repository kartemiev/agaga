<?php
namespace Vpbxui\OperatorStat\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\OperatorStat\Model\OperatorStatTable;

class OperatorStatTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            return new OperatorStatTable(
                $serviceLocator->get('Vpbxui\OperatorStat\Model\OperatorStatTableGateway')
                );
        }     
}