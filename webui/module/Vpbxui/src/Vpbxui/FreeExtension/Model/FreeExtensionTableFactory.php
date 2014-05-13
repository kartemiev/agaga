<?php
namespace Vpbxui\FreeExtension\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\FreeExtension\Model\FreeExtensionTable;

class FreeExtensionTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\FreeExtension\Model\FreeExtensionTableGateway');
        return new FreeExtensionTable($tableGateway);
    }    
}