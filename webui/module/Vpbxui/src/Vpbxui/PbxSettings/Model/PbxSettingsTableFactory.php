<?php
namespace Vpbxui\PbxSettings\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\PbxSettings\Model\PbxSettingsTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class PbxSettingsTableFactory implements FactoryInterface
{      
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $tableGateway = $serviceLocator->get('Vpbxui\PbxSettings\Model\PbxSettingsTableGateway');            
            $table = new PbxSettingsTable(
            		$tableGateway,
            		$serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidProvider')
				);
            return $table;
        } 
    
}