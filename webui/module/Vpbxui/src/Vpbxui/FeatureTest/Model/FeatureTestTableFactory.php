<?php
namespace Vpbxui\FeatureTest\Model;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class FeatureTestTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\FeatureTest\Model\FeatureTestTableGateway');
        return new FeatureTestTable(
        			$tableGateway 
				);
    }    
}