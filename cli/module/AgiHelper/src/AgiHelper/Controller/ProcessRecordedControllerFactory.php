<?php
namespace AgiHelper\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AgiHelper\Controller\ProcessRecordedController;

class ProcessRecordedControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new ProcessRecordedController(
        		$sl->get('AgiHelper\RecordedCall\Model\RecordedCallTable'),
        		$sl->get('AgiHelper\Service\RecordedCall\RecordedCallCommands'),
        		$sl->get('AgiHelper\Service\RecordedCall\PurgeOldRecordings')
				);
    }
}