<?php
namespace Vpbxui\Extension\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use Zend\Db\TableGateway\TableGateway;

class ExtensionTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $extension = $serviceLocator->get('Vpbxui\Extension\Model\Extension');
        $resultSetPrototype->setArrayObjectPrototype($extension);
        $featureSet = new FeatureSet();
        $featureSet->addFeature(new SequenceFeature('id','sip_serial'));        
        return new TableGateway('sip', $dbAdapter, $featureSet, $resultSetPrototype);
    }
}