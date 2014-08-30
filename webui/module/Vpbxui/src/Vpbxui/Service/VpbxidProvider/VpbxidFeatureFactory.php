<?php
namespace Vpbxui\Service\VpbxidProvider;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VpbxidFeatureFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new VpbxidFeature(
                $serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidProvider')
             );
    }            
}