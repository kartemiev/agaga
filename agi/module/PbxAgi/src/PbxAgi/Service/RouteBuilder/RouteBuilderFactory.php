<?php
namespace PbxAgi\Service\RouteBuilder;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\RouteBuilder\RouteBuilder;

class RouteBuilderFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
      	$trunkDestinationTable = $serviceLocator->get('PbxAgi\TrunkDestination\Model\TrunkDestinationTable');    
    	$trunkTable = $serviceLocator->get('PbxAgi\Trunk\Model\TrunkTable');	
    	$destinationValidator = $serviceLocator->get('PbxAgi\Service\RouteBuilder\DestinationValidator');
    	$routeValidator = $serviceLocator->get('PbxAgi\Service\RouteBuilder\RouteValidator');
        return new RouteBuilder(
          			$trunkDestinationTable, 
        			$trunkTable,
        			$destinationValidator,
        			$routeValidator
				);
    }
}