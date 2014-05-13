<?php
namespace Vpbxui\Route\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Route\Form\RouteForm; 

class RouteFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return  new RouteForm( 
        		$serviceLocator->get('Vpbxui\Route\Form\RouteDestinationFieldset')
  		);       
    }
}