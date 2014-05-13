<?php
namespace PbxAgi\GeneralSettings\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\GeneralSettings\Model\GeneralSettingsTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class GeneralSettingsTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('PbxAgi\GeneralSettings\Model\GeneralSettingsTableGateway');
        $table = new GeneralSettingsTable($tableGateway);
        return $table;
    }
}