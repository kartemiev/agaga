<?php
namespace PbxAgi\Extension\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
use PbxAgi\Extension\Model\Extension;
use Zend\Db\TableGateway\Feature\FeatureSet;

class ExtensionTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $featureSet = new FeatureSet();
        $featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));        
        return new TableGateway('sip', $dbAdapter, $featureSet, new HydratingResultSet(new ReflectionHydrator(), new Extension()));
    }
}
