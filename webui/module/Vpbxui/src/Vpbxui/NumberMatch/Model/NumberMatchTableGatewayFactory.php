<?php
namespace Vpbxui\NumberMatch\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\NumberMatch\Model\NumberMatch;
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
        $featureSet->addFeature(new SequenceFeature('id','number_match_id_seq'));
        $featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
        return new TableGateway('number_match', $dbAdapter, $featureSet, $resultSetPrototype);
    }
}