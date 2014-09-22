<?php
 
namespace Restful;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {                    
        $sm = $e->getApplication()->getServiceManager();
    }
  
     public function setVariableToLayout($event)
	{
    	$viewModel = $event->getViewModel();
    	$sm = $event->getApplication()->getServiceManager();
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
            'Restful\Controller\WizardFreeDid'=>'Restful\Controller\WizardFreeDidControllerFactory',
            'Restful\Controller\VpbxEnv' => 'Restful\Controller\VpbxEnvControllerFactory',
            'Restful\Controller\WizardMediaDefault'=>'Restful\Controller\WizardMediaDefaultControllerFactory'
            ),
     );
    }
     
    
}
