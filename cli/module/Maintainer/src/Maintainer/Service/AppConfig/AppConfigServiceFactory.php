<?php
namespace Maintainer\Service\AppConfig;

use Zend\ServiceManager\FactoryInterface;
use Maintainer\Service\AppConfig\AppConfigService;
use Zend\ServiceManager\ServiceLocatorInterface;

class AppConfigServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $config = (isset($config['maintainer'])) ? $config['maintainer'] : null;
        return new AppConfigService($config);
     }
}