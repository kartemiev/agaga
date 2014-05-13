<?php
namespace PbxAgi\Service\ShortDialMenu\GotoShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\ExistingShortDialValidator;

class ExistingShortDialValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $shortDialTable = $serviceLocator->get('PbxAgi\ShortDial\Model\ShortDialTable');
        $call = $serviceLocator->get('CallEntity');
        return new ExistingShortDialValidator($shortDialTable, $call);
    }
}