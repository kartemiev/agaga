<?php
namespace PbxAgi\FaxSpoolLog\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
use PbxAgi\FaxSpool\Model\FaxSpool;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;

class FaxSpoolLogTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $featureSet = new FeatureSet();
        $featureSet->addFeature(new SequenceFeature('id','faxspoollog_id_seq'));
        $featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
        return new TableGateway('faxspool', $dbAdapter, $featureSet, 
            new HydratingResultSet(new ReflectionHydrator(), new FaxSpool()));
    }
}
