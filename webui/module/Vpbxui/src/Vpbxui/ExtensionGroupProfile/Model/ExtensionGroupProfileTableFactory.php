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
         $table = new ExtensionGroupProfileTable(
        					$tableGateway
 						);
        return $table;
    }
}