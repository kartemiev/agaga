<?php
namespace Vpbxui\CdrMissedCallsCallCentre\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\CdrMissedCallsCallCentre\Model\CdrMissedCallsCallCentreTable;

class CdrMissedCallsCallCentreTableFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $tableGateway = $serviceLocator->get('Vpbxui\CdrMissedCallsCallCentre\Model\CdrMissedCallsCallCentreTableGateway');
        return new CdrMissedCallsCallCentreTable($tableGateway);       
    }

}
