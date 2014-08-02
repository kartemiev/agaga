<?php
 
namespace Saas;

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
        		'GizzleClient'=>'Saas\Gizzle\ClientFactory',
        		'Saas\Did\Model\DidTable'=>'Saas\Did\Model\DidTableFactory',
        		'Saas\Did\Model\DidTableGateway' => 'Saas\Did\Model\DidTableGatewayFactory',
        		'Saas\FreeDid\Model\FreeDidTable'=>'Saas\FreeDid\Model\FreeDidTableFactory',
        		'Saas\FreeDid\Model\FreeDidTableGateway' => 'Saas\FreeDid\Model\FreeDidTableGatewayFactory',
        		'Saas\VpbxEnv\Model\VpbxEnvTable'=>'Saas\VpbxEnv\Model\VpbxEnvTable',
        		'Saas\VpbxEnv\Model\VpbxEnvTableGateway'=> 'Saas\VpbxEnv\Model\VpbxEnvTableGatewayFactory',
        		'Saas\WizardSessionContainer\WizardSessionContainer' =>'Saas\WizardSessionContainer\WizardSessionContainerFactory'
           ),
	    );
    }
    public function getControllerConfig()
    {
         return array(
        'factories'=> array(
        		'Saas\Controller\PickDid' => 'Saas\Controller\PickDidControllerFactory',
        		'Saas\Controller\VpbxWizard' => 'Saas\Controller\VpbxWizardControllerFactory',
        		'Saas\Controller\UploadMedia' => 'Saas\Controller\UploadMediaControllerFactory',
        		'Saas\Controller\CreateInternal' => 'Saas\Controller\CreateInternalControllerFactory'
        		
            ),
     );
    }
     
    
}
