<?php
namespace PbxAgi\Service\ClientImpl;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ClientImpl\HangupAndQuit;

class HangupAndQuitFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $agi = $serviceLocator->get('ClientImpl');
        return new HangupAndQuit($agi);
    }
}