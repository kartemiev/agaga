<?php
namespace Vpbxui\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PAMI\Client\Impl\ClientImpl;

class AmiClientServiceFactory implements FactoryInterface
{   
    public function createService(ServiceLocatorInterface $serviceLocator) {
     
        $config = $serviceLocator->get('Config');
        $options = (isset($config['ami']))?$config['ami']:null;
        return new ClientImpl($options);
    }
}
