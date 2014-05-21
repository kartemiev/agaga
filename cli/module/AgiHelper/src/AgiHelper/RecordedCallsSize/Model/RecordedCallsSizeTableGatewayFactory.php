<?php
namespace AgiHelper\RecordedCallsSize\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use AgiHelper\RecordedCallsSize\Model\RecordedCallsSize;

class RecordedCallsSizeTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator) {
           $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
           $resultSetPrototype = new ResultSet();
           $resultSetPrototype->setArrayObjectPrototype(new RecordedCallsSize());
           return new TableGateway('recorded_calls_size', $dbAdapter, null, $resultSetPrototype);
	}	
}