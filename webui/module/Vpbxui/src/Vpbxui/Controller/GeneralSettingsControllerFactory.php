<?php
namespace Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Controller\GeneralSettingsController;
 
class GeneralSettingsControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?
        $serviceLocator->getServiceLocator() : $serviceLocator;
      $generalSettingsTable = $sl->get('Vpbxui\GeneralSettings\Model\GeneralSettingsTable');
         return new GeneralSettingsController($generalSettingsTable);
    }
}