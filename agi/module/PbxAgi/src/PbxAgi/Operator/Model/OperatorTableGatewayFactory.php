<?php
namespace PbxAgi\Operator\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use PbxAgi\Operator\Model\Operator;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\FeatureSet;

class OperatorTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
         $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Operator());
        $featureSet = new FeatureSet();
        $featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
        $tg = new TableGateway('sip', $dbAdapter, $featureSet, $resultSetPrototype);
        return $tg;
    }
}
