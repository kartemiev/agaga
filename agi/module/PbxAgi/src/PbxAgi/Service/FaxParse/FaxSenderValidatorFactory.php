<?php
namespace PbxAgi\Service\FaxParse;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\FaxParse\FaxSenderValidator;

class FaxSenderValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new FaxSenderValidator(
	       $serviceLocator->get('PbxAgi\FaxUser\Model\FaxUserTable'),
            $serviceLocator->get('PbxAgi\Service\FaxParse\FaxRetrieveSender')            
        );
    }
}