<?php
namespace PbxAgi\NumberMatch\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use PbxAgi\NumberMatch\Model\NumberMatch;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;

class NumberMatchTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new HydratingResultSet();
        $resultSetPrototype->setObjectPrototype(new NumberMatch());        
        $featureSet = new FeatureSet();
        $featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
        return new TableGateway('number_match', $dbAdapter, $featureSet, $resultSetPrototype);
    }
}