<?php
namespace PbxAgi\ShortDial\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use PbxAgi\ShortDial\Model\ShortDial; 
use Zend\Db\TableGateway\Feature\SequenceFeature;
use Zend\Db\TableGateway\Feature\FeatureSet;

class ShortDialTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ShortDial());
        $featureSet = new FeatureSet();        
        $featureSet->addFeature(new SequenceFeature('id','shortdialtable_id_seq'));
        $featureSet->addFeature('PbxAgi\Service\VpbxidProvider\VpbxidFeature');
        return new TableGateway('shortdialtable', $dbAdapter, $featureSet, $resultSetPrototype);
        
    }
}
