<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\NewShortDialValidator;
use Zend\ServiceManager\ServiceLocatorInterface;

class ShortDialDstValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new NewShortDialValidator();        
    }
}