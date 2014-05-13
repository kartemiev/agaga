<?php
namespace Vpbxui\Feature\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Feature\Model\FeatureTable;

class FeatureTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $tableGateway = $serviceLocator->get('Vpbxui\Feature\Model\FeatureTableGateway');
       return new FeatureTable($tableGateway);
    }
}