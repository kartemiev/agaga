<?php
namespace PbxAgi\RecordedCall\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class RecordedCallTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator) {
           $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
           $resultSetPrototype = new ResultSet();
           $resultSetPrototype->setArrayObjectPrototype(new RecordedCall());
           return new TableGateway('RecordedCall', $dbAdapter, null, $resultSetPrototype);
	}	
}