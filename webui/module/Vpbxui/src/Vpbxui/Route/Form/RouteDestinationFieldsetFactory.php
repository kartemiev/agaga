<?php
namespace Vpbxui\Route\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Route\Form\RouteDestinationFieldset;

class RouteDestinationFieldsetFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return  new RouteDestinationFieldset( 
        		$serviceLocator->get('Vpbxui\Trunk\Model\TrunkTable'),
        		$serviceLocator->get('Vpbxui\NumberMatch\Model\NumberMatchTable')
 		);       
    }
}