<?php
namespace PbxAgi\Peer\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
//use Zend\Db\ResultSet\HydratingResultSet;
use PbxAgi\Extension\Model\Extension;
//use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;

class PeerTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Extension());
        return new TableGateway('sip', $dbAdapter, null, $resultSetPrototype);
                
    }
}
