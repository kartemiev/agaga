<?php
namespace Vpbxui\Extension\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Extension\Model\ExtensionTable;

class ExtensionTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\Extension\Model\ExtensionTableGateway');
         return new ExtensionTable(
        			$tableGateway
				);
    }    
}