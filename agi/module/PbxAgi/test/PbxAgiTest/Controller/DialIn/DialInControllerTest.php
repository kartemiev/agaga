<?php
namespace PbxAgiTest\Controller\DialIn;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PbxAgi\Controller\Plugin\MockedRedirector;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Controller\FeatureControllerFactory;
use PAGI\CallerId\Impl\CallerIdFacade;
use PbxAgi\Controller\FaxReceiveControllerFactory;
use PbxAgi\FaxSpool\Model\FaxSpool;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Controller\FaxReceiveController;
use PbxAgi\Service\SendEmail\SendEmail;
use PbxAgi\Service\SendEmail\EmailMessage;
use PbxAgi\Controller\DialInControllerFactory;

class DialInControllerTest extends AbstractControllerTestCase
{
  
     protected $mockedVarManager;
     protected $mockedAgi;
 	 protected $mockedTransferControllerPlugin;
     protected $mockedPrepareCallControllerPlugin;
     protected $mockedTimeControllerPlugin;
     protected $mockedForward;
     protected $mockedAppConfig;
      public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);  

        $appConfig =  $serviceManager->get('AppConfig');
        
        
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
                        ->method('getBusinessHoursGreeting')
                        ->with()
                        ->will($this->returnValue('/var/lib/asterisk/mediarepos/22/22'));
        
        

        $mockedAppConfig->expects($this->any())
                        ->method('getIncomingPstnMenuInputTotalMaxOfftime')
                        ->with()
                        ->will($this->returnValue(8000));
        

        $mockedAppConfig->expects($this->any())
                        ->method('getOffTimeGreeting')
                        ->with()
                        ->will($this->returnValue('/var/lib/asterisk/mediarepos/24/24'));
        
        
        $mockedAppConfig->expects($this->any())
                        ->method('getDialSipExtensionContextName')
                        ->with()
                        ->will($this->returnValue('dialsipexten'));
        
        
        $mockedAppConfig->expects($this->any())
                        ->method('getCallCentreContextName')
                        ->with()
                        ->will($this->returnValue('callcentre'));
        
        
        $this->mockedVarManager =  $this->getMockBuilder('PbxAgi\Service\ChannelVarManager\ChannelVarManager')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        $serviceManager->setService('ChannelVarManager', $this->mockedVarManager);
        
        $this->mockedAgi = new MockedClientImpl(array());
        $serviceManager->setService('ClientImpl', $this->mockedAgi);
        
        
        $dialInControllerTestFactory = new DialInControllerFactory();
        $this->controller = $dialInControllerTestFactory->createService($serviceManager);

        $this->mockedTransferControllerPlugin =  $this->getMockBuilder('PbxAgi\Controller\Plugin\TransferControllerPlugin')
        	->disableOriginalConstructor()
        	->getMock();
        
        $this->controller->getPluginManager()
        				 ->setService('TransferControllerPlugin', $this->mockedTransferControllerPlugin);

        
        $this->mockedForward =  $this->getMockBuilder('Zend\Mvc\Controller\Plugin\Forward')
                                     ->disableOriginalConstructor()
                                      ->getMock();
        
        $this->controller->getPluginManager()
                        ->setService('forward', $this->mockedForward);
        
        
        $this->controller->getPluginManager()
        				 ->setService('ClosurizePlugin', new \PbxAgi\Controller\Plugin\ClosurizeControllerPlugin());

        
        $this->mockedPrepareCallControllerPlugin =  $this->getMockBuilder('PbxAgi\Controller\Plugin\PrepareCallControllerPlugin')
        	 ->disableOriginalConstructor()
        	 ->getMock();
        
        $this->controller->getPluginManager()
        	  ->setService('PrepareCallControllerPlugin', $this->mockedPrepareCallControllerPlugin);
        
        
        $this->mockedTimeControllerPlugin = $this->getMockBuilder('PbxAgi\Controller\Plugin\TimeControllerPlugin')
        	->disableOriginalConstructor()
        	->getMock();
        
        $this->controller->getPluginManager()
        	->setService('TimeControllerPlugin', $this->mockedTimeControllerPlugin);
        
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'DialIn'));
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
          
     public function test_dialin_controller_can_reach_internal_number_working_hours()
    {
 
    	$mockedClient = $this->mockedAgi;
    	$mockedClient
    	->assert('answer')
    	->assert('streamFile',array("silence/1","0123456789*#"))    	
    	->assert('streamFile',array("/var/lib/asterisk/mediarepos/22/22","0123456789*#"))    	 
    	->assert('waitDigit')    	 
     	->assert('waitDigit')
    	->assert('dial',array("Local/860@dialsipexten/n"))     
     	->onAnswer(true)
    	->onStreamFile(false)   
    	->onStreamFile(true,'8')    	
    	->onWaitDigit(true,'6') 
    	->onWaitDigit(true,'0')

    	->onDial(false,null,null,null,'ANSWERED',null)    	 
    	    	;
    	
    	$this->mockedTimeControllerPlugin->expects($this->atLeastOnce())
    	->method('isWorkingHours')
    	->will($this->returnValue(true));
    	 
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }
    
    public function test_dialin_controller_can_reach_callcentre_working_hours()
    {

    	$mockedClient = $this->mockedAgi;
    	$mockedClient
    		->assert('answer')
    		->assert('streamFile',array("silence/1","0123456789*#"))
    		->assert('streamFile',array("/var/lib/asterisk/mediarepos/22/22","0123456789*#"))
    		->assert('waitDigit',array(4000))
    		->assert('dial',array("Local/run@callcentre/n",array(null, 'm(1_ringingtone)')))    	 
    		->assert('hangup')     	 
    		->onAnswer(true)    	
    		->onStreamFile(false)
    		->onStreamFile(false)
    		->onWaitDigit(false)    
    		->onDial(false,null,null,null,'ANSWERED',null)    	 
    		->onHangup(true)     	 
    	;
    	
    	$this->mockedTimeControllerPlugin->expects($this->atLeastOnce())
    		->method('isWorkingHours')
    		->will($this->returnValue(true));    	
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }
    public function test_dialin_controller_can_reach_internal_number_offtime_hours()
    {
    
    	$mockedClient = $this->mockedAgi;
    	$mockedClient
    	->assert('answer')
    	->assert('streamFile',array("silence/1","0123456789*#"))
    	->assert('streamFile',array("/var/lib/asterisk/mediarepos/24/24","0123456789*#"))
    	->assert('waitDigit')
    	->assert('waitDigit')
    	->assert('dial',array("Local/860@dialsipexten/n"))
    	->onAnswer(true)
    	->onStreamFile(false)
    	->onStreamFile(true,'8')
    	->onWaitDigit(true,'6')
    	->onWaitDigit(true,'0')
    
    	->onDial(false,null,null,null,'ANSWERED',null)
    	;
    	 
    	$this->mockedTimeControllerPlugin->expects($this->atLeastOnce())
    	->method('isWorkingHours')
    	->will($this->returnValue(false));
    
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }
    
    
    public function test_dialin_controller_can_join_conference()
    {
    
    	$mockedClient = $this->mockedAgi;
    	$mockedClient
    	->assert('answer')
    	->assert('streamFile',array("silence/1","0123456789*#"))
    	->assert('streamFile',array("/var/lib/asterisk/mediarepos/24/24","0123456789*#"))
    	->assert('waitDigit')
    	->assert('waitDigit')
    	->onAnswer(true)
    	->onStreamFile(false)
    	->onStreamFile(true,'*')
    	->onWaitDigit(true,'9')
    	->onWaitDigit(true,'0')    
    	;
    
    	$this->mockedForward->expects($this->once())
    	     ->method('dispatch')
    	     ->with('PbxAgi\Controller\ConferenceController', array('action'=>'join'))
    	       ->will($this->returnValue(true));
    	 
    	
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }

    
    
    public function test_dialin_controller_cannot_reach_callcentre_offtime_hours()
    {
    
    	$mockedClient = $this->mockedAgi;
    	$mockedClient
    	->assert('answer')
    	->assert('streamFile',array("silence/1","0123456789*#"))
    	->assert('streamFile',array("/var/lib/asterisk/mediarepos/24/24","0123456789*#"))
    	->assert('waitDigit',array(8000))
     	->assert('hangup')
    	->onAnswer(true)
    	->onStreamFile(false)
    	->onStreamFile(false)
    	->onWaitDigit(false)
     	->onHangup(true)
    	;
    	 
     	
    	$this->mockedTimeControllerPlugin->expects($this->atLeastOnce())
    	                                 ->method('isWorkingHours')
    	                                 ->will($this->returnValue(false));
    	$result   = $this->controller->dispatch($this->request);
    	$response = $this->controller->getResponse();
    }
}