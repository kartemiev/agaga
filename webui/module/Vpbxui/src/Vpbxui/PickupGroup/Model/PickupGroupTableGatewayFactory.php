<?php
namespace Vpbxui\PickupGroup\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
use Vpbxui\PickupGroup\Model\PickupGroup;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\Feature\FeatureSet;

class PickupGroupTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new PickupGroup());
        $featureSet = new FeatureSet();
        $featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
        return new TableGateway('pickupgroup', $dbAdapter, $featureSet, $resultSetPrototype);
    }    
}
