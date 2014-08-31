<?php
namespace PbxAgi\Conference\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use PbxAgi\Conference\Model\Conference;
use Zend\Db\ResultSet\ResultSet; 
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;

class ConferenceTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Conference());
        $featureSet = new FeatureSet();
        $featureSet->addFeature(new SequenceFeature('id','conference_serial'));
        $featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
        return new TableGateway('conference', $dbAdapter, $featureSet, $resultSetPrototype);
                
    }
}
