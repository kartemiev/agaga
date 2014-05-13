<?php
namespace Vpbxui\GeneralSettings\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\GeneralSettings\Model\GeneralSettingsTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class GeneralSettingsTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\GeneralSettings\Model\GeneralSettingsTableGateway');
        $table = new GeneralSettingsTable($tableGateway);
        return $table;
    }
}