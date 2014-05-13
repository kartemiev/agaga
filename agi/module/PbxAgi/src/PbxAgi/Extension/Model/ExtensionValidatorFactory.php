<?php
namespace PbxAgi\Extension\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Extension\Model\ExtensionValidator;

class ExtensionValidatorFactory implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
       $extensionTable = $serviceLocator->get('ExtensionTable');
          return new ExtensionValidator($extensionTable);
    }
 
}
