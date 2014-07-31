<?php
namespace Did\FreeDid\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;  
use Did\Gizzle\ApiGateway;
use Zend\Stdlib\Hydrator\ClassMethods;

class FreeDidTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{	 
		$config =  $serviceLocator->get('Config');
		$gizzleconfig = isset($config['gizzle'])?$config['gizzle']:array();
 		$apiGateway = new ApiGateway($gizzleconfig);
 		$apiGateway->setUrl('/api/did/free');
 		$apiGateway->setArrayObjectPrototype(new FreeDid());
 		$apiGateway->setDefaultHydrator(new ClassMethods());
 		return $apiGateway;
	}
}