<?php
namespace PbxAgi\Operator\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use PbxAgi\Operator\Model\Operator;
use Zend\Db\ResultSet\ResultSet;

class OperatorTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
         $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Operator());
        $tg = new TableGateway('sip', $dbAdapter, null, $resultSetPrototype);
        return $tg;
    }
}
