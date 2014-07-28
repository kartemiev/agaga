<?php
namespace Vpbxui\ExtensionGroup\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\ExtensionGroup\Model\ExtensionGroupTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionGroupTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\ExtensionGroup\Model\ExtensionGroupTableGateway');
        $vpbxidProvider = $serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidProvider');
        
        $table = new ExtensionGroupTable(
        		$tableGateway,
        		$vpbxidProvider
			);
        return $table;
    }
}