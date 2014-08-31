<?php
namespace PbxAgi\GeneralSettings\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\GeneralSettings\Model\GeneralSettings;
use Zend\Db\TableGateway\Feature\FeatureSet;

class GeneralSettingsTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {         
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new GeneralSettings());
        $featureSet = new FeatureSet();
        $featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
        return new TableGateway('pbx_settings', $dbAdapter, $featureSet, $resultSetPrototype);
    }    
}