<?php
namespace Saas\Service\AppConfig;

use Zend\ServiceManager\FactoryInterface;
use Saas\Service\AppConfig\AppConfigService;
use Zend\ServiceManager\ServiceLocatorInterface;

class AppConfigServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $config = (isset($config['saas'])) ? $config['saas'] : null;
          return new AppConfigService($config);;
    }
}