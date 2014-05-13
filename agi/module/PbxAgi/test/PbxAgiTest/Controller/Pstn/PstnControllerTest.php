<?php
namespace PbxAgiTest\Controller\Pstn;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Controller\PstnControllerFactory;
use PbxAgi\Entity\CallEntity;
use PbxAgi\Entity\CallOriginatorEntity;
use PbxAgi\Entity\CallOwnerEntity;
use PbxAgi\Entity\CallDestinatorEntity;
use PbxAgi\Trunk\Model\Trunk;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Exception\ChannelDownException;

class PstnControllerTest extends AbstractControllerTestCase
{  
     protected $mockedVarManager;
     protected $mockedAgi;
     protected $mockedSkypeAliasResolver;
     protected $mockedFeatureCheckPermissionPlugin;
     protected $mockedRouteBuilder;
     protected $skypeAliasResolver;
     protected $mockedPrepareCallControllerPlugin;
      public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);  
         
        $this->mockedVarManager =  $this->getMockBuilder('PbxAgi\Service\ChannelVarManager\ChannelVarManager')
        						  ->disableOriginalConstructor()
        						  ->getMock();
                
                
        $serviceManager->setService('ChannelVarManager', $this->mockedVarManager);
        
         
        $this->mockedRouteBuilder = $this->getMockBuilder('PbxAgi\Service\RouteBuilder\RouteBuilder')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        $serviceManager->setService('PbxAgi\Service\RouteBuilder\RouteBuilder', $this->mockedRouteBuilder);
        
        
        
        $this->mockedAgi = new MockedClientImpl(array());
        $serviceManager->setService('ClientImpl', $this->mockedAgi);
        
        $this->mockedSkypeAliasResolver =  $this->getMockBuilder('PbxAgi\Service\SkypeAliasResolver\SkypeAliasResolver')
        								  ->disableOriginalConstructor()
        								  ->getMock();
        $serviceManager->setService('PbxAgi\Service\SkypeAliasResolver\SkypeAliasResolver', $this->mockedSkypeAliasResolver);

        
        $pstnControllerFactory = new PstnControllerFactory();
        $this->controller = $pstnControllerFactory->createService($serviceManager);
 

         
        
        
        
        
        $this->mockedPrepareCallControllerPlugin =  $this->getMockBuilder('PbxAgi\Controller\Plugin\PrepareCallControllerPlugin')
        												 ->disableOriginalConstructor()
        												 ->getMock();
        
        
        $this->controller->getPluginManager()
        				  ->setService('PrepareCallControllerPlugin', $this->mockedPrepareCallControllerPlugin);
        
        
        
        
        $this->mockedFeatureCheckPermissionPlugin =  $this->getMockBuilder('PbxAgi\Controller\Plugin\FeatureCheckPermissionPlugin')
        												  ->disableOriginalConstructor()
        												  ->getMock();
        
        
        $this->controller->getPluginManager()->setService('FeatureCheckPermissionPlugin', $this->mockedFeatureCheckPermissionPlugin);
        
      
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'Pstn'));
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
          
     public function test_pstn_controller_can_dispatch_to_pstn_number_or_skype_alias()
    {
 
    	$mockedClient = $this->mockedAgi;
    	$mockedClient
    	 
    	->assert('dial',array('SIP/testtrunk/vasya_pupkin',array(60,'KM(callrecord)TW'))) 	 
  
    	->onDial(false,null,null,null,'ANSWER',null)    	 
    	    	;
    	
		$callOwner = new CallOwnerEntity();
    	$callOriginator = new CallOriginatorEntity();
    	
    	$callOriginator->setRouteref(1);    
    	
    	$callDestinator = new CallDestinatorEntity();
    	
    	$call = new CallEntity($callOwner, $callOriginator, $callDestinator);
    	
    	$call->setExten('2018');
    	
    	$this->mockedPrepareCallControllerPlugin->expects($this->once())
    		 ->method('initCall')
    		 ->will($this->returnValue($call));
    	
    	$this->mockedFeatureCheckPermissionPlugin->expects($this->once())
    		 ->method('__invoke')
    		 ->with('outgoingcallspermission',array('allowed','undefined'))
    		 ->will($this->returnValue(true));
    	    	
    	$this->mockedRouteBuilder->expects($this->once())
    		 ->method('setNumber')
    		 ->with('2018')
    		 ->will($this->returnValue(true));
    	 
    	$this->mockedRouteBuilder->expects($this->once())
    		 ->method('setId')
    		 ->with(1)
    		 ->will($this->returnValue(true));
    	
    	$this->mockedVarManager->expects($this->once())
    	     ->method('getCallerTransferPermission')
    	     ->with()
    	     ->will($this->returnValue(true));
    	
    	$this->mockedRouteBuilder->expects($this->once())
    		 ->method('create')
    		 ->will($this->returnValue(true));

    	$trunk = new Trunk();
    	$trunk->name = 'testtrunk';
    	$trunk->callerid = '+74951234567';
    	
		$trunkDestinations = array($trunk);
    	$this->mockedRouteBuilder->expects($this->once())
    		 ->method('getDestinations')
    		 ->will($this->returnValue($trunkDestinations));
    
    	$this->mockedSkypeAliasResolver->expects($this->once())
    		 ->method('resolve')
    		 ->with('2018')
    		 ->will($this->returnValue('vasya_pupkin'));
    	
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }     

    public function test_pstn_controller_handle_when_exception_is_thrown()
    {
    
    	$callOwner = new CallOwnerEntity();
    	$callOriginator = new CallOriginatorEntity();
    	 
    	$callOriginator->setRouteref(1);
    	 
    	$callDestinator = new CallDestinatorEntity();
    	 
    	$call = new CallEntity($callOwner, $callOriginator, $callDestinator);
    	 
    	$call->setExten('2018');
    	 
    	$this->mockedPrepareCallControllerPlugin->expects($this->once())
    	->method('initCall')
    	->will($this->returnValue($call));
    	 
    	$this->mockedFeatureCheckPermissionPlugin->expects($this->once())
    	->method('__invoke')
    	->with('outgoingcallspermission',array('allowed','undefined'))
    	->will($this->returnValue(true));
    
    	$this->mockedRouteBuilder->expects($this->once())
    	->method('setNumber')
    	->with('2018')
    	->will($this->returnValue(true));
    
    	$this->mockedRouteBuilder->expects($this->once())
    	->method('setId')
    	->with(1)
    	->will($this->returnValue(true));
    	 
    	$this->mockedRouteBuilder->expects($this->once())
    	->method('create')
    	->will($this->returnValue(true));
    
    	$trunk = new Trunk();
    	$trunk->name = 'testtrunk';
    	$trunk->callerid = '+74951234567';
    	 
    	$trunkDestinations = array($trunk);
    	$this->mockedRouteBuilder->expects($this->once())
    	->method('getDestinations')
    	->will($this->returnValue($trunkDestinations));
    
    	$this->mockedSkypeAliasResolver->expects($this->once())
    	->method('resolve')
    	->with('2018')
    	->will($this->throwException(new ChannelDownException()));
    	 
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }
    
    
    
    public function test_pstn_controller_can_handle_skype_alias_resolutuon_failure()
    {
    
    	$callOwner = new CallOwnerEntity();
    	$callOriginator = new CallOriginatorEntity();
    	 
    	$callOriginator->setRouteref(1);
    	 
    	$callDestinator = new CallDestinatorEntity();
    	 
    	$call = new CallEntity($callOwner, $callOriginator, $callDestinator);
    	 
    	$call->setExten('2018');
    	 
    	$this->mockedPrepareCallControllerPlugin->expects($this->once())
    	->method('initCall')
    	->will($this->returnValue($call));
    	 
    	$this->mockedFeatureCheckPermissionPlugin->expects($this->once())
    	->method('__invoke')
    	->with('outgoingcallspermission',array('allowed','undefined'))
    	->will($this->returnValue(true));
    
    
    	$this->mockedSkypeAliasResolver->expects($this->once())
    	->method('resolve')
    	->with('2018')
    	->will($this->returnValue(false));
    	 
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }
    
    public function test_pstn_controller_can_barr_calls_on_barred_originator()
    {
    
        $mockedClient = $this->mockedAgi;
        $mockedClient->assert('hangup',array(AppConfigInterface::AST_HANGUPCAUSE_OUTGOING_CALL_BARRED))        
                     ->onHangup(true)
        ;
        
    	$callOwner = new CallOwnerEntity();
    	$callOriginator = new CallOriginatorEntity();
    	 
    	$callOriginator->setRouteref(1);
    	 
    	$callDestinator = new CallDestinatorEntity();
    	 
    	$call = new CallEntity($callOwner, $callOriginator, $callDestinator);
    
    	$call->setExten('84956408040');
    	 
    	$this->mockedPrepareCallControllerPlugin->expects($this->once())
    	->method('initCall')
    	->will($this->returnValue($call));
    	 
    	$this->mockedFeatureCheckPermissionPlugin->expects($this->once())
    	->method('__invoke')
    	->with('outgoingcallspermission',array('allowed','undefined'))
    	->will($this->returnValue(false));
    
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }
    public function test_can_handle_hangup_action()
    {
        $this->routeMatch->setParam('action', 'hangup');
        
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
    }
}