<?php
namespace PbxAgi\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\Plugin\FeatureCheckPermissionPlugin;

class FeatureCheckPermissionPluginFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;        
        $callEntity = $sl->get('CallEntity');
        $permissionResolver = $sl->get('PbxAgi\Service\PermissionResolver\PermissionResolver');
        $featureCheckPermissionPlugin = new FeatureCheckPermissionPlugin($callEntity, $permissionResolver);   
        return $featureCheckPermissionPlugin;
    }    
}