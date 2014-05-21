<?php

namespace AgiHelper;

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
                'AgiHelper\Controller\ProcessRecorded'=>'Maintainer\Controller\ProcessRecordedFactory'
         )
        );
    }
    public function getServiceConfig()
    {
        return array(
          'invokables'=> array(          		
        ),
          'factories' => array(
          		'AgiHelper\RecordedCall\Model\RecordedCallTable'=>'AgiHelper\RecordedCall\Model\RecordedCallTableFactory',
          		'AgiHelper\RecordedCall\Model\RecordedCallTableGateway'=>'AgiHelper\RecordedCall\Model\RecordedCallTableGatewayFactory',
          		'AgiHelper\RecordedCallsSize\Model\RecordedCallsSizeTable' => 'AgiHelper\RecordedCallsSize\Model\RecordedCallsSizeTableFactory',
          		'AgiHelper\RecordedCallsSize\Model\RecordedCallsSizeTableGateway' => 'AgiHelper\RecordedCallsSize\Model\RecordedCallsSizeTableGatewayFactory',
          		'AgiHelper\Cdr\Model\CdrTable' => 'AgiHelper\Cdr\Model\CdrTableFactory',
          		'AgiHelper\Cdr\Model\CdrTableGateway' => 'AgiHelper\Cdr\Model\CdrTableGatewayFactory',
          		'AgiHelper\Service\AppConfig\AppConfigService' => 'AgiHelper\Service\AppConfig\AppConfigServiceFactory',
          		'AgiHelper\Service\RecordedCall\RecordedCallCommands' => 'AgiHelper\Service\RecordedCall\RecordedCallCommandsFactory',
          		'AgiHelper\Service\RecordedCall\PurgeOldRecordings' => 'AgiHelper\Service\RecordedCall\PurgeOldRecordingsFactory'
             )          
        );
    }
}
