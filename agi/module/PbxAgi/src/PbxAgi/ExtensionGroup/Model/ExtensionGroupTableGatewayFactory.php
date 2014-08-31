<?php
namespace PbxAgi\ExtensionGroup\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
use PbxAgi\ExtensionGroup\Model\ExtensionGroup;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\Feature\FeatureSet;

class ExtensionGroupTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ExtensionGroup());
        $featureSet = new FeatureSet();
        $featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
        return new TableGateway('extensiongroups', $dbAdapter, $featureSet, $resultSetPrototype);
    }    
}