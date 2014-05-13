<?php
namespace Vpbxui\Role\Model;
use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Role\Model\RoleTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleTableFactory implements FactoryInterface
{     
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $tableGateway = $serviceLocator->get('Vpbxui\Role\Model\RoleTableGateway');
            $table = new RoleTable($tableGateway);
            return $table;
        } 
    
}