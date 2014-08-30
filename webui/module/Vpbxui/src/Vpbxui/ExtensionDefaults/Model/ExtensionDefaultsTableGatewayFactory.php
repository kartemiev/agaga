<?php
namespace Vpbxui\ExtensionDefaults\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
use Vpbxui\ExtensionDefaults\Model\ExtensionDefaults;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\Feature\FeatureSet;

class ExtensionDefaultsTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ExtensionDefaults());
        $featureSet = new FeatureSet();
        $featureSet->addFeature($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
        return new TableGateway('extensiondefaults', $dbAdapter, $featureSet, $resultSetPrototype);
    }    
}