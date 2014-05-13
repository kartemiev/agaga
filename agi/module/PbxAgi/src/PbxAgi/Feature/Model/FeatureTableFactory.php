<?php
namespace PbxAgi\Feature\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Feature\Model\FeatureTable;

class FeatureTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $tableGateway = $serviceLocator->get('PbxAgi\Feature\Model\FeatureTableGateway');
       return new FeatureTable($tableGateway);
    }
}