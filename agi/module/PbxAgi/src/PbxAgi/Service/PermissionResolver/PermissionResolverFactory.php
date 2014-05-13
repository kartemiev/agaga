<?php
namespace PbxAgi\Service\PermissionResolver;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\PermissionResolver\PermissionResolver;

class PermissionResolverFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
      	$permissionNodeFactory = $serviceLocator->get('PbxAgi\Service\PermissionResolver\PermissionNodeFactory');    
     
        return new PermissionResolver(
        			$permissionNodeFactory
				);
    }
}