<?php
namespace Vpbxui\SkypeAlias\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\SkypeAlias\Model\SkypeAliasTable;

class SkypeAliasTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\SkypeAlias\Model\SkypeAliasTableGateway');
        return new SkypeAliasTable($tableGateway);
    }    
}