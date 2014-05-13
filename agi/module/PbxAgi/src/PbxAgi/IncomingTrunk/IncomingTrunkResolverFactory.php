<?php
namespace PbxAgi\IncomingTrunk;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\IncomingTrunk\IncomingTrunkResolver;

class IncomingTrunkResolverFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $entityResolverFactory = $serviceLocator->get('PbxAgi\EntityResolver\EntityResolverFactory');
        $instance = new IncomingTrunkResolver($entityResolverFactory);
        return $instance;
    }
}
