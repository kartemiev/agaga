<?php
namespace PbxAgi\Entity;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Entity\CallEntity;
use Zend\ServiceManager\ServiceLocatorInterface;

class CallEntityFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CallEntity(
                $serviceLocator->get('CallOwner'),
                $serviceLocator->get('CallOriginator'),
                $serviceLocator->get('CallDestinator')
                );
    }
}
