<?php
namespace PbxAgi\FaxSpool\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
use PbxAgi\FaxSpool\Model\FaxSpool;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;

class FaxSpoolTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $featureSet = new FeatureSet();
        $featureSet->addFeature(new SequenceFeature('id','faxspool_id_seq'));
        return new TableGateway('faxspool', $dbAdapter, $featureSet, 
            new HydratingResultSet(new ReflectionHydrator(), new FaxSpool()));
    }
}
