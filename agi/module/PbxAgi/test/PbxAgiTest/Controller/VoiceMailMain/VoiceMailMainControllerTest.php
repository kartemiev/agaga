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
use PbxAgi\Controller\VoiceMailMainControllerFactory;
use PbxAgi\Entity\CallEntity;
use PbxAgi\Entity\CallOwnerEntity;
use PbxAgi\Entity\CallOriginatorEntity;
use PbxAgi\CallDestination\Model\CallDestination;
use PbxAgi\Entity\CallDestinatorEntity;

class VoiceMailMainControllerTest extends AbstractControllerTestCase
{
     protected $mockedAgi;
  	 protected $mockedPrepareCallControllerPlugin; 
      public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);  

        

        $this->mockedAgi = new MockedClientImpl(array());
        $serviceManager->setService('ClientImpl', $this->mockedAgi);
        
        $voiceMailMainControllerFactory = new VoiceMailMainControllerFactory();
        $this->controller = $voiceMailMainControllerFactory->createService($serviceManager);
 
        
        
        $this->mockedPrepareCallControllerPlugin =  $this->getMockBuilder('PbxAgi\Controller\Plugin\PrepareCallControllerPlugin')
        												 ->disableOriginalConstructor()
        												 ->getMock();
        
        
        $this->controller->getPluginManager()
        ->setService('PrepareCallControllerPlugin', $this->mockedPrepareCallControllerPlugin);
        
      
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'PbxAgi\Controller\VoiceMailMain'));
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
          
     public function test_voicemail_main_controller_can_call_voicemail_main_command()
    {
 
    	$mockedClient = $this->mockedAgi;
    	$mockedClient
    				->assert('answer')   				
     				 ->assert('hangup')
    				 ->onAnswer(true)    				 	
    				 ->addMockedResult('200 result=0')
    				 ->onHangup(true)
     	    	;
    	$callOwner = new CallOwnerEntity();
    	$callOriginator = new CallOriginatorEntity();
    	$callOriginator->setMailbox('1');
    	$callDestinator = new CallDestinatorEntity();
    	$call = new CallEntity($callOwner, $callOriginator, $callDestinator);
    	 $this->mockedPrepareCallControllerPlugin->expects($this->once())
    		 ->method('initCall')
     		 ->will($this->returnValue($call));
    	 
    	
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }
    
 
}