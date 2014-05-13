<?php
namespace Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Controller\StatController;

class StatControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $amiclient = $serviceLocator->get('AmiClient');
        $instance = new StatController();
        $instance->setAmiclient($amiclient);
        return $instance;
    }
}