<?php
namespace Maintainer\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Maintainer\Controller\RecordingBackupController;

class RecordingBackupControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new RecordingBackupController(
            $sl->get('Maintainer\Service\AppConfig\AppConfigService'),
            $sl->get('Maintainer\Cdr\Model\CdrTable'),
            $sl->get('Maintainer\Service\BackupRecording\BackupDomDocument'),
            $sl->get('Maintainer\Service\BackupRecording\BackupDomDocumentWriter'),
            $sl->get('Maintainer\Service\BackupRecording\BackupRecordingMedia'),
            $sl->get('Maintainer\Service\LockHandler\LockHandler')
        );
    }
}