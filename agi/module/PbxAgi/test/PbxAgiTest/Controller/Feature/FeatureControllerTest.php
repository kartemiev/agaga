<?php
namespace PbxAgiTest\Controller\PickupFeature;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PbxAgi\Controller\Plugin\MockedRedirector;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Controller\FeatureControllerFactory;

      
class FeatureControllerTest extends AbstractControllerTestCase
{
     protected $mockedForward;
     protected $mockedFeatureTable;
     protected $mockedVarManager;
      public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);  

        $mockedVarManager =  $this->getMockBuilder('PbxAgi\Service\ChannelVarManager\ChannelVarManager')
                                  ->disableOriginalConstructor()
                                  ->getMock();

        $serviceManager->setService('ChannelVarManager', $mockedVarManager);

        $mockedFeatureTable =  $this->getMockBuilder('PbxAgi\Feature\Model\FeatureTable')
                                  ->disableOriginalConstructor()
                                  ->getMock();
        
        $serviceManager->setService('PbxAgi\Feature\Model\FeatureTable', $mockedFeatureTable);
        
        $this->mockedFeatureTable = $mockedFeatureTable;        
        
        
        $this->mockedVarManager = $mockedVarManager;        
        
        $mockedForward =  $this->getMockBuilder('Zend\Mvc\Controller\Plugin\Forward')
                               ->disableOriginalConstructor()
                               ->getMock();
         $this->mockedForward = $mockedForward;
                
        $featureControllerFactory = new FeatureControllerFactory();
        $this->controller = $featureControllerFactory->createService($serviceManager);

        $this->controller->getPluginManager()
        				 ->setService('forward', $mockedForward);
        
        
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
        $this->routeMatch->setParam('action', 'Index');
        
     }
    
      
     public function test_feature_controller_can_dispatch_to_conference()
     {
     	$this->mockedVarManager->expects($this->once())
     	                       ->method('getExten')
      	                       ->will($this->returnValue(2));

     	
     	
     	try
     	{
               $result   = $this->controller->dispatch($this->request);
     	       $response = $this->controller->getResponse();     	
     	 }
     	catch (\Exception $e)
     	{
     		$this->assertSame('Unrecognized feature requested', $e->getMessage());
     		return;
     	}
     	
     	$this->fail('Expected exception was not thrown');
     	
      }
     public function test_feature_controller_throws_an_exception_when_wrong_feature_is_requested()
     {
           
     	$this->mockedVarManager->expects($this->any())
     	                       ->method('getExten')
     	                       ->will($this->returnValue(1));

     	
     	
     	$this->mockedForward->expects($this->once())
     	                       ->method('dispatch')
     	                       ->with('PbxAgi\Controller\ConferenceController',array('action'=>'join'))
     	                       ->will($this->returnValue(null));
     
     	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
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
    
}