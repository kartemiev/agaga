<?php
namespace Did\Did\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Agaga\Entity\Did;
use Did\Gizzle\ApiGateway;
use Zend\Stdlib\Hydrator\ClassMethods;

class DidTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$config = $serviceLocator->get('Config');		
 		$apiGateway = new ApiGateway($config);
 		$apiGateway->setUrl('/api/did/free'); 		
 		$apiGateway->setArrayObjectPrototype(new Did());
 		$apiGateway->setDefaultHydrator(new ClassMethods());  			
 		return $apiGateway;
	}
}