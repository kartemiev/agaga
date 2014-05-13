<?php
namespace PbxAgi\Service\RouteBuilder;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\RegEntry\Model\RegEntryTableInterface;
use PbxAgi\Service\RouteBuilder\RouteValidator;

class RouteValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$routeTable = $serviceLocator->get('PbxAgi\Route\Model\RouteTable');
    	return new RouteValidator($routeTable);
    }
}