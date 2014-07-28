<?php
 
namespace Did;

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
        		'GizzleClient'=>'Did\Gizzle\ClientFactory',
        		'Did\Did\Model\DidTable'=>'Did\Did\Model\DidTableFactory',
        		'Did\Did\Model\DidTableGateway' => 'Did\Did\Model\DidTableGatewayFactory',
        		'Did\FreeDid\Model\FreeDidTable'=>'Did\FreeDid\Model\FreeDidTableFactory',
        		'Did\FreeDid\Model\FreeDidTableGateway' => 'Did\FreeDid\Model\FreeDidTableGatewayFactory'
           ),
	    );
    }
    public function getControllerConfig()
    {
         return array(
        'factories'=> array(
        		'Did\Controller\PickDid' => 'Did\Controller\PickDidControllerFactory'
            ),
     );
    }
     
    
}
