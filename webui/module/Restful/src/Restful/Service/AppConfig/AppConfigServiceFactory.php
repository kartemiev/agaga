<?php
namespace Restful\Service\AppConfig;

use Zend\ServiceManager\FactoryInterface;
use Restful\Service\AppConfig\AppConfigService;
use Zend\ServiceManager\ServiceLocatorInterface;

class AppConfigServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $config = (isset($config['restful'])) ? $config['restful'] : null;
          return new AppConfigService($config);;
    }
}