<?php
namespace Vpbxui\ExtensionGroupProfile\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionGroupProfileTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTableGateway');
        $vpbxidProvider = $serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidProvider');        
        $table = new ExtensionGroupProfileTable(
        					$tableGateway,
        					$vpbxidProvider
						);
        return $table;
    }
}