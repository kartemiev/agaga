<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\ParseFaxEmailController;

class ParseFaxEmailControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    
        $sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new ParseFaxEmailController(
        		$sl->get('PbxAgi\Service\SendEmail\SendEmail'),
        		$sl->get('AppConfig'),        		
        		$sl->get('PbxAgi\FaxSpool\Model\FaxSpoolTable'),
        		$sl->get('PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTable'),
        		$sl->get('PbxAgi\Service\Reader\Reader'),        		
        		$sl->get('PbxAgi\Service\Writer\Writer'),
        		$sl->get('PbxAgi\Service\Executer\Executer'),
        		$sl->get('PbxAgi\Service\CallSpoolImpl\CallSpoolImpl'),
                $sl->get('PbxAgi\Service\FaxParse\FaxSenderValidator'),
                $sl->get('PbxAgi\Service\FaxParse\FaxAttachmentFormatValidator'),
                $sl->get('PbxAgi\Service\FaxParse\FaxRetrieveAttachment'),
                $sl->get('PbxAgi\Service\FaxParse\FaxRetrieveSender'),
                $sl->get('PbxAgi\Service\FaxParse\FaxAttachmentPresentValidator')
            
 		);
    }
}