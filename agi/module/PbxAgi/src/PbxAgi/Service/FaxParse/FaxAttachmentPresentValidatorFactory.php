<?php
namespace PbxAgi\Service\FaxParse;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\FaxParse\FaxSenderValidator;

class FaxAttachmentPresentValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new FaxAttachmentPresentValidator(
	       $serviceLocator->get('PbxAgi\Service\FaxParse\FaxRetrieveAttachment')            
        );
    }
}