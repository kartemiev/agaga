<?php
namespace PbxAgi\Conference\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Conference\Model\ConferenceValidator;

class ConferenceValidatorFactory implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $conferenceTable = $serviceLocator->get('PbxAgi\Conference\Model\ConferenceTable');
            return new ConferenceValidator($conferenceTable);
    } 
}
