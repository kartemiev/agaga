<?php
namespace PbxAgi\Service\AppConfig;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Service\AppConfig\AppConfigService;
use Zend\ServiceManager\ServiceLocatorInterface;

class AppConfigServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $config = (isset($config['pbxagi'])) ? $config['pbxagi'] : null;
        $instance = new AppConfigService($config);
        $generalSettingsTable = $serviceLocator->get('PbxAgi\GeneralSettings\Model\GeneralSettingsTable');          
        $vpbxidProvider = $serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidProvider');
//        $generalSettings = $generalSettingsTable->getSettings(AppConfigInterface::VPBX_ID);
//        $instance->setGeneralSettings($generalSettings);
        $instance->setGeneralSettingsTable($generalSettingsTable);
        $instance->setVpbxidProvider($vpbxidProvider);
        return $instance;
    }
}