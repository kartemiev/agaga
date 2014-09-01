<?php
namespace Saas\Did\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Saas\Gizzle\ApiGateway;
use Saas\Did\Model\Did;
use Zend\Stdlib\Hydrator\ObjectProperty;

class DidTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$config = $serviceLocator->get('Config');		
 		$apiGateway = new ApiGateway($config);
 		$apiGateway->setUrl('/api/did/free'); 		
 		$apiGateway->setArrayObjectPrototype(new Did());
 		$apiGateway->setDefaultHydrator(new ObjectProperty());  			
 		return $apiGateway;
	}
}