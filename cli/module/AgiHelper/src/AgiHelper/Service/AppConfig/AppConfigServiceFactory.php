<?php
namespace AgiHelper\Service\AppConfig;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AgiHelper\Service\AppConfig\AppConfigService;

class AppConfigServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $config = (isset($config['agihelper'])) ? $config['agihelper'] : null;
        return new AppConfigService($config);
     }
}