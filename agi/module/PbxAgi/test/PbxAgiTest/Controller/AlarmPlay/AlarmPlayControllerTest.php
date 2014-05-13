<?php
namespace PbxAgiTest\Controller\AlarmPlay;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Controller\AlarmPlayControllerFactory;
use PbxAgi\GenericWrappers\DateTime;

class AlarmPlayControllerTest extends AbstractControllerTestCase
{
  
     protected $mockedAgi;
     protected $stubDateTime;     
      public function setUp()
    {
        
        $serviceManager = Bootstrap::getServiceManager();         
        $this->serviceManager = $serviceManager;
        $serviceManager->setAllowOverride(true);  

        
        $this->mockedAgi = new MockedClientImpl(array());
        $serviceManager->setService('ClientImpl', $this->mockedAgi);
        
        
        $alarmPlayControllerFactory = new AlarmPlayControllerFactory();

       
        $stubDateTime = new \DateTime();

        $this->stubDateTime = $stubDateTime;
        $stubDateTime->setTime(23, 30, 0);
        $serviceManager->setService('PbxAgi\GenericWrappers\DateTime', $stubDateTime);
                  
        
        $this->controller = $alarmPlayControllerFactory->createService($serviceManager);
        
      
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'AlarmPlay'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
                 
        
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this->routeMatch->setParam('action', 'index');        
     }
     public function test_alarm_play_can_play_alarm_notification_correctly()
     {
          
         
        $stubDateTime = $this->stubDateTime; 	
     	$mockedClient = $this->mockedAgi;
     	$mockedClient->assert('answer')
     	             ->assert('streamFile',array('silence/1'))
     	             ->assert('sayNumber',array('23'))
     	             ->assert('streamFile',array('silence/1'))
     	             ->assert('sayNumber',array('30'))
     	             ->assert('streamFile',array('silence/1'))
     	             ->assert('streamFile',array('silence/1'))
     	             ->assert('sayNumber',array('23'))
     	             ->assert('streamFile',array('silence/1'))
     	             ->assert('sayNumber',array('30'))
     	             ->assert('streamFile',array('silence/1'))     	              
     	             ->assert('hangup')
     	             ->onAnswer(true)     	              
     	             ->onStreamFile(false)
     	             ->onSayNumber(false)
     	             ->onStreamFile(false)
     	             ->onSayNumber(false)
     	             ->onStreamFile(false)
     	             ->onStreamFile(false)
     	             ->onSayNumber(false)
     	             ->onStreamFile(false)
     	             ->onSayNumber(false)
     	             ->onStreamFile(false)    	              
      	             ->onHangup(true)
     	;
     	     	      	 
     	 
     	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
     }
     
     
} 