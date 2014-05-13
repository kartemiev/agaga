<?php
namespace PbxAgi\Service\ConferenceMenu\Hangup;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ConferenceMenu\Hangup\HangupCommand;

class HangupCommandFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new HangupCommand($serviceLocator->get('ClientImpl'));
    }
}