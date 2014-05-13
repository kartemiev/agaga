<?php
namespace PbxAgiTest\Controller\RecordCall;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Controller\RecordCallControllerFactory;

class RecordCallControllerTest extends AbstractControllerTestCase
{  
     protected $mockedAgi;
     protected $mockedCdrFacade;
      public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);  
         
        $this->mockedAgi = new MockedClientImpl(array());
        $serviceManager->setService('ClientImpl', $this->mockedAgi);

        $this->mockedCdrFacade =  $this->getMockBuilder('PAGI\CDR\Impl\CDRFacade')
        								->disableOriginalConstructor()
        								->getMock();
        
        $recordCallControllerFactory = new RecordCallControllerFactory();
        $this->controller = $recordCallControllerFactory->createService($serviceManager);
         
      
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'RecordCall'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
  
        $pluginManager = $this -> controller->getPluginManager();
        
         
        $mockedFeatureCheckPermissionPlugin = $this->getMockBuilder('PbxAgi\Controller\Plugin\FeatureCheckPermissionPlugin')
        ->disableOriginalConstructor()
        ->getMock();
        $this->mockedFeatureCheckPermissionPlugin = $mockedFeatureCheckPermissionPlugin;
        $pluginManager->setService('FeatureCheckPermissionPlugin', $mockedFeatureCheckPermissionPlugin);
        
        
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
      }
          
     /*
      * temporarily disabled - got stuck with "some methods are not called error"
      */
     public function test_update_cdr()
     {
         $this->routeMatch->setParam('action', 'updateCDR');
          
         $mockedClient = $this->mockedAgi;
         
         $this->mockedAgi
         ->assert('getVariable',array('DIALSTATUS'))
         ->onGetVariable(true,'ANSWER')
         ->addMockedResult("200 result=0")
          
          ;
         $result   = $this->controller->dispatch($this->request);
         $response = $this->controller->getResponse();
        $this->assertTrue($this->controller->updateCDR());  
     }
     public function test_disabled_test_pstn_controller_can_dispatch_to_pstn_number()
    {
         $this->routeMatch->setParam('action', 'index');
        
    	$mockedClient = $this->mockedAgi;

    	$this->mockedAgi
    		 ->assert('getVariable',array('RECORD_FILENAME'))
    		 ->onGetVariable(true,'32902848048384084')
    		 ->addMockedResult("200 result=0")
    		 ->addMockedResult("200 result=0")
    		  
    	 
    	    	    	;
      	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }     
}