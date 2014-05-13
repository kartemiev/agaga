<?php
namespace Vpbxui\Roles\Model;
use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Roles\Model\RolesTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class RolesTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $tableGateway = $serviceLocator->get('Vpbxui\Roles\Model\RolesTableGateway');
            $table = new RolesTable($tableGateway);
            return $table;
        } 
    
}