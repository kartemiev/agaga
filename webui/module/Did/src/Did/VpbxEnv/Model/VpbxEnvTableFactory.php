<?php
namespace Did\VpbxEnv\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VpbxEnvTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $apiGateway = $serviceLocator->get('Did\VpbxEnv\Model\VpbxEnvTableGateway');
       return new VpbxEnvTable($apiGateway);
    }
}