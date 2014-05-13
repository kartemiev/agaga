<?php
namespace Vpbxui\AuthCode\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\AuthCode\Model\AuthCodeTable;

class AuthCodeTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $tableGateway = $serviceLocator->get('Vpbxui\AuthCode\Model\AuthCodeTableGateway');
            $table = new AuthCodeTable($tableGateway);
            return $table;
        }     
}