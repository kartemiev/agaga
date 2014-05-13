<?php
namespace PbxAgi\Service\RouteBuilder;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\RegEntry\Model\RegEntryTableInterface;
 
class DestinationValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$regEntryTable = $serviceLocator->get('PbxAgi\RegEntry\Model\RegEntryTable');
    	return new DestinationValidator($regEntryTable);
    }
}