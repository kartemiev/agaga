<?php
namespace PbxAgi\Service\DialString;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SimpleTimeParserFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	return new SimpleTimeParser($serviceLocator->get('PbxAgi\GenericWrappers\DateTime'));
    }
}