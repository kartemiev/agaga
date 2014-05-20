<?php

namespace Maintainer;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getControllerConfig()
    {
        return array(
            'factories'=>array(
                'Maintainer\Controller\RecordingBackup'=>'Maintainer\Controller\RecordingBackupControllerFactory'
         )
        );
    }
    public function getServiceConfig()
    {
        return array(
          'invokables'=> array(
            'Maintainer\Service\BackupRecording\BackupDomDocument'=>'Maintainer\Service\BackupRecording\BackupDomDocument',
            'Maintainer\Service\BackupRecording\BackupDomDocumentWriter' => 'Maintainer\Service\BackupRecording\BackupDomDocumentWriter',
            'Maintainer\Service\LockHandler\LockHandler' => 'Maintainer\Service\LockHandler\LockHandler'              
        ),
          'factories' => array(
              'Maintainer\Cdr\Model\CdrTable' => 'Maintainer\Cdr\Model\CdrTableFactory',
              'Maintainer\Cdr\Model\CdrTableGateway' => 'Maintainer\Cdr\Model\CdrTableGatewayFactory',
              'Maintainer\Service\AppConfig\AppConfigService' => 'Maintainer\Service\AppConfig\AppConfigServiceFactory',
              'Maintainer\Service\BackupRecording\BackupRecordingMedia' => 'Maintainer\Service\BackupRecording\BackupRecordingMediaFactory', 
              'Maintainer\Service\AppConfig\AppConfigService'=>'Maintainer\Service\AppConfig\AppConfigServiceFactory',
             )          
        );
    }
}
