<?php
namespace Maintainer\Service\BackupRecording;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Maintainer\Service\BackupRecording\BackupRecordingMedia;

class BackupRecordingMediaFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new BackupRecordingMedia(
            $serviceLocator->get('Maintainer\Service\AppConfig\AppConfigService')
        );
    }
}