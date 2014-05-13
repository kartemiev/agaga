<?php
namespace PbxAgi\OperatorStatusLog\Model;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use PbxAgi\OperatorStatusLog\Model\OperatorStatusLog;
use Zend\Db\ResultSet\ResultSet;

class OperatorStatusLogTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
         $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new OperatorStatusLog());
        return new TableGateway('operator_status_log', $dbAdapter, null, $resultSetPrototype);
    }
}
