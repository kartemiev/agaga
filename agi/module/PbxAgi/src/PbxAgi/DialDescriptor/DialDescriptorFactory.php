<?php
namespace PbxAgi\DialDescriptor;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\DialDescriptor\DialDescriptor;

class DialDescriptorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dialOptions = $serviceLocator->get('PbxAgi\DialDescriptor\DialOptionsDescriptor');
        return new DialDescriptor($dialOptions);
    }    
}