<?php
namespace Did\Vpbx\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VpbxTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $apiGateway = $serviceLocator->get('Did\Vpbx\Model\VpbxTableGateway');
       return new VpbxTable($apiGateway);
    }
}