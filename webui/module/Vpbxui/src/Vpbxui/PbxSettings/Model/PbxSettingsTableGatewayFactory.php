<?php
namespace Vpbxui\PbxSettings\Model;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\PbxSettings\Model\PbxSettings;
use Zend\Db\ResultSet\ResultSet;
use Zend\ServiceManager\FactoryInterface;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;

class PbxSettingsTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new PbxSettings());
        $featureSet = new FeatureSet();
        $featureSet->addFeature(new SequenceFeature('vpbxid','pbx_settings_seq'));
         return new TableGateway('pbx_settings', $dbAdapter, $featureSet, $resultSetPrototype);
    }
}