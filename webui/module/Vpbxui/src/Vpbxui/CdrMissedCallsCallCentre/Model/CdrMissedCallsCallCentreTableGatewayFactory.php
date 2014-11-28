<?php
namespace Vpbxui\CdrMissedCallsCallCentre\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\CdrMissedCallsCallCentre\Model\CdrMissedCallsCallCentre;
use Zend\Db\TableGateway\Feature\FeatureSet;

class CdrMissedCallsCallCentreTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CdrMissedCallsCallCentre());
        $featureSet = new FeatureSet();
        return new TableGateway('cdr_callcentre_calls_missed', $dbAdapter, $featureSet, $resultSetPrototype);
    }
}