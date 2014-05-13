<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\NewShortDialValidator;

class NewShortDialValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new NewShortDialValidator();
    }
}