<?php
namespace PbxAgi\CallDestination\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\CallDestination\Model\CallDestination;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class CallDestinationTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
    	$resultSetPrototype = new ResultSet();
    	$callDestination = new CallDestination();
    	$resultSetPrototype->setArrayObjectPrototype($callDestination);
    	return new TableGateway('call_destination', $dbAdapter, null, $resultSetPrototype);
    }
}