<?php
namespace PbxAgiTest\Controller\DialExtension;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Controller\DialExtensionControllerFactory;
use PbxAgi\Extension\Model\Extension;

class DialExtensionControllerTest extends AbstractControllerTestCase
{
  
   	protected $mockedExtensionTable;
     protected $mockedVarManager;
     protected $mockedAgi;
 	 protected $mockedTransferControllerPlugin;
     protected $mockedPrepareCallControllerPlugin;
     protected $mockedTimeControllerPlugin;
     protected $mockedExtensionValidator;
     protected $mockedAppConfig;
      public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);  

        $mockedAppConfig = $this->getMockBuilder('PbxAgi\Service\AppConfig\AppConfigService')
                                ->disableOriginalConstructor()
                                ->getMock();
        
        $this->mockedAppConfig = $mockedAppConfig;
        $serviceManager->setService('AppConfig', $mockedAppConfig);
        
        $mockedAppConfig->expects($this->any())
                         ->method('getMohInternalState')
                         ->with()
                         ->will($this->returnValue(true));
        
        $mockedAppConfig->expects($this->any())
                        ->method('getExtensionSipReceiveIncomingContextName')
                        ->with()
                        ->will($this->returnValue('extenreceive'));
        
        
        
        
         $this->mockedExtensionTable = $this->getMockBuilder('PbxAgi\Extension\Model\ExtensionTable')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        $serviceManager->setService('ExtensionTable', $this->mockedExtensionTable);

        
        
        $this->mockedVarManager =  $this->getMockBuilder('PbxAgi\Service\ChannelVarManager\ChannelVarManager')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        $serviceManager->setService('ChannelVarManager', $this->mockedVarManager);
        
        $this->mockedExtensionValidator =  $this->getMockBuilder('PbxAgi\Extension\Model\ExtensionValidator')
        										->disableOriginalConstructor()
        										->getMock();
        $serviceManager->setService('ExtensionValidator', $this->mockedExtensionValidator);
        
        
        
        
        $this->mockedAgi = new MockedClientImpl(array());
        $serviceManager->setService('ClientImpl', $this->mockedAgi);
        
        
        $dialExtenControllerFactory = new DialExtensionControllerFactory();
        $this->controller = $dialExtenControllerFactory->createService($serviceManager);
 
        
      
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'DialExtension'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
  
        
        $pluginManager = $this->controller->getPluginManager();
        
         
        $mockedFeatureCheckPermissionPlugin = $this->getMockBuilder('PbxAgi\Controller\Plugin\FeatureCheckPermissionPlugin')
                                                   ->disableOriginalConstructor()
                                                   ->getMock();
        $this->mockedFeatureCheckPermissionPlugin = $mockedFeatureCheckPermissionPlugin;
        $pluginManager->setService('FeatureCheckPermissionPlugin', $mockedFeatureCheckPermissionPlugin);
        
        

        $this->mockedFeatureCheckPermissionPlugin->expects($this->any())
                                                 ->method('__invoke')
                                                 ->with('extensionrecord',array('active','undefined'),'CallDestinator')
                                                 ->will($this->returnValue(true));
        
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this->routeMatch->setParam('action', 'index');        
     }
     public function test_hangup_action()
     {
     	$serviceManager = Bootstrap::getServiceManager();
     
     	$config = $serviceManager->get('Config');
     	$routerConfig = isset($config['router']) ? $config['router'] : array();
     	$router = HttpRouter::factory($routerConfig);
     	 
     	$this->routeMatch = new RouteMatch(array('controller' => 'hangup'));
     
     	$this->event->setRouter($router);
     	$this->event->setRouteMatch($this->routeMatch);
     	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
     	$this->routeMatch->setParam('action', 'Hangup');
     	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
     }
     
     public function test_dialexten_controller_can_dispatch_to_correct_extension_with_correct_parameters()
    {
 
    	$mockedClient = $this->mockedAgi;
    	$mockedClient
    	->assert('getVariable',array('EXTEN'))
//    	->assert('getVariable',array('UNIQUEID'))  
//    	->assert('getVariable',array('CHANNEL'))   
    	->assert('dial',array('Local/304@extenreceive/n',array(60,'M(callrecord)mTtg'))) 	 
    	->onGetVariable(true,'304')
//    	->onGetVariable(true,'1252500762.337')    	 
//    	->onGetVariable(true,'SIP/305-00000014')
    	->onDial(false,null,null,null,'ANSWERED',null)    	 
    	    	;
    	
    	
    	$this->mockedVarManager->expects($this->once())
    		 ->method('getCallerTransferPermission')
    		 ->will($this->returnValue(true));
    	
    	 
    	$this->mockedExtensionValidator->expects($this->once())
    		 ->method('isValid')
    		 ->with('304')
    		 ->will($this->returnValue(true));    	 
     	
        $extensionRecord = new Extension();
        $extensionRecord->exchangeArray(
    		array(
        	'id'=>'1',
    		'extensionrecord'=>'active'
        )
        );
    	$this->mockedExtensionTable->expects($this->any())
    	->method('getExtension')
    	->with('304')
    	->will($this->returnValue($extensionRecord));
    	
    	 
    	
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }
  
}