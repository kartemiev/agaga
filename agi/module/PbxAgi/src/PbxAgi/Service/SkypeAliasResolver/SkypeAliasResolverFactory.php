<?php
namespace PbxAgi\Service\SkypeAliasResolver;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\SkypeAliasResolver\SkypeAliasResolver;

class SkypeAliasResolverFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
         return  new SkypeAliasResolver(
						$serviceLocator->get('PbxAgi\SkypeAlias\Model\SkypeAliasTable')
 					);
    }
}