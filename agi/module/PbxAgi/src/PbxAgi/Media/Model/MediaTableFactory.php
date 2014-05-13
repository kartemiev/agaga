<?php
namespace PbxAgi\Media\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Media\Model\MediaTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtensionTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mediatable = $serviceLocator->get('MediaTableGateway');
        $instance = new MediaTable($mediatable);
        return $instance;
    }
}
