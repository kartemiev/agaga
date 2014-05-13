<?php
namespace PbxAgi\SkypeAlias\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\SkypeAlias\Model\SkypeAliasTable;

class SkypeAliasTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('PbxAgi\SkypeAlias\Model\SkypeAliasTableGateway');
        return new SkypeAliasTable($tableGateway);
    }    
}