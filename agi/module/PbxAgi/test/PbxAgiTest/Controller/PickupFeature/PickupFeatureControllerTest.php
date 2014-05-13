<?php
namespace PbxAgiTest\Controller\PickupFeature;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use PbxAgi\Controller\PickupFeatureControllerFactory;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PbxAgi\Controller\Plugin\MockedRedirector;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 

      
class PickupFeatureControllerTest extends AbstractControllerTestCase
{
   private $mockedClientImpl;
   
      public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
        $this->mockedClientImpl = new MockedClientImpl(array());         
        $serviceManager->setService('ClientImpl', $this->mockedClientImpl);   
         
        $pickupFeatureControllerFactory = new PickupFeatureControllerFactory;
        $this->controller = $pickupFeatureControllerFactory->createService($serviceManager);
        
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
  
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
 
     }
    
      
       public function test_do_pickup()
    {
     	$this->routeMatch->setParam('action', 'Pickup');
    	 
        $mockedClient = $this->mockedClientImpl;
       $mockedClient
            ->assert('answer')
             ->assert('hangup')
            
             ->onAnswer(true)
             ->addMockedResult("200 result=0")
             ->onHangup(true)              
                    ;        
       $result   = $this->controller->dispatch($this->request);
       $response = $this->controller->getResponse();
     	
    	
    }
     
    
}
