<?php
 
namespace SaasBootstrap;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;
use SaasBootstrap\Service\VpbxEnv\VpbxEnvHandler;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {                    
        $sm = $e->getApplication()->getServiceManager();
        $eventManager = $e->getApplication()->getEventManager();      
        $events = $eventManager->getSharedManager();
        $events->attach('Vpbxui\Controller\RegisterPbxController', 'register.preDispatch', array(new VpbxEnvHandler(),'postUserRegistration'));        
    }
  
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
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
    public function getServiceConfig()
    {
        return array(
        'factories' => array(
     
           ),
	    );
    }
    public function getControllerConfig()
    {
         return array(
        'factories'=> array(
         
            ),
     );
    }
     
    
}
