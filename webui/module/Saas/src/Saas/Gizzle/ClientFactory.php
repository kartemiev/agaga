<?php
namespace Saas\Gizzle;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use GuzzleHttp\Client;

class ClientFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$config = $serviceLocator->get('Config');	
		var_dump($config);
		throw new \Exception();	 
		return new Client($config['gizzle']);
	}
}