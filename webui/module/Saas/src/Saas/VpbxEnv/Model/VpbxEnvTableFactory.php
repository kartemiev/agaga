<?php
namespace Saas\VpbxEnv\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VpbxEnvTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $apiGateway = $serviceLocator->get('Saas\VpbxEnv\Model\VpbxEnvTableGateway');
       return new VpbxEnvTable($apiGateway);
    }
}