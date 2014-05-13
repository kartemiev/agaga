<?php
namespace Vpbxui\Cdr\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class CdrTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator) {
           $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
           $resultSetPrototype = new ResultSet();
           $resultSetPrototype->setArrayObjectPrototype(new Cdr());
           return new TableGateway('cdr', $dbAdapter, null, $resultSetPrototype);
	}	
}