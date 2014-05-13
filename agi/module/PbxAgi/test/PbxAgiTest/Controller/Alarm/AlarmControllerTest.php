<?php
namespace PbxAgiTest\Controller\Alarm;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Controller\DialExtensionControllerFactory;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\Controller\AlarmControllerFactory;
use PbxAgi\Entity\CallEntity;
use PbxAgi\Entity\CallOwnerEntity;
use PbxAgi\Entity\CallOriginatorEntity;
use PbxAgi\CallDestination\Model\CallDestination;
use PbxAgi\Entity\CallDestinatorEntity;
use PbxAgi\Controller\AlarmController;
use PAGI\CallSpool\CallFile;
use PbxAgi\DialDescriptor\DialDescriptor;
use PbxAgi\DialDescriptor\LocalDialDescriptor;

class AlarmControllerTest extends AbstractControllerTestCase
{
  
     protected $mockedAgi;
     protected $mockedPrepareCallControllerPlugin;
     protected $mockedSimpleTimeWithoutSemicolumnValidator;
     protected $mockedAppConfig;
     protected $pluginManager;
     protected $mockedCallSpoolImpl;
     protected $mockedSimpleTimeParser;
     protected $serviceManager;
     protected $moockedCallSpoolImpl;
     protected $mockedCallSpoolImplFactory;
     protected $mockedVarManager;
       public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $this->serviceManager = $serviceManager;
        $serviceManager->setAllowOverride(true);  

        $mockedAppConfig = $this->getMockBuilder('PbxAgi\Service\AppConfig\AppConfigService')
                                ->disableOriginalConstructor()
                                ->getMock();
        
        $this->mockedAppConfig = $mockedAppConfig;
        $serviceManager->setService('AppConfig', $mockedAppConfig);
        
        
        $mockedVarManager = $this->getMockBuilder('PbxAgi\Service\ChannelVarManager\ChannelVarManager')
                                 ->disableOriginalConstructor()
                                 ->getMock();
        
        $this->mockedVarManager = $mockedVarManager;
        $serviceManager->setService('ChannelVarManager', $mockedVarManager);
        
        
        
        
        
        $this->mockedAgi = new MockedClientImpl(array());
        $serviceManager->setService('ClientImpl', $this->mockedAgi);
        
        
        $alarmControllerFactory = new AlarmControllerFactory();

        

        $mockedCallSpoolImpl = $this->getMockBuilder('PAGI\CallSpool\Impl\CallSpoolImpl')
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->mockedCallSpoolImpl = $mockedCallSpoolImpl;
        
        $mockedCallSpoolImplFactory = $this->getMockBuilder('PbxAgi\Service\CallSpoolImpl\CallSpoolImplFactory')
                                           ->disableOriginalConstructor()
                                           ->getMock();
        
        $serviceManager->setService('PbxAgi\Service\CallSpoolImpl\CallSpoolImpl', $mockedCallSpoolImplFactory);
        
        $this->mockedCallSpoolImplFactory = $mockedCallSpoolImplFactory;
        
        $callSpoolImplOptions = array(
        		'tmpDir' => '/tmp',
        		'spoolDir' => '/var/spool/asterisk'
        );
        
         $mockedDateTime = $this->getMockBuilder('PbxAgi\GenericWrappers\DateTime')
                               ->disableOriginalConstructor()
                               ->getMock();
        
        
        $this->controller = $alarmControllerFactory->createService($serviceManager);
        
      
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'Alarm'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
   
        
        
        
        $pluginManager = $this->controller->getPluginManager();
        
        $this->pluginManager = $pluginManager; 
         
        
        $mockedSimpleTimeWithoutSemicolumnValidator = $this->getMockBuilder('PbxAgi\Validator\Time\SimpleTimeWithoutSemicolumnValidator')
                                                           ->disableOriginalConstructor()
                                                           ->getMock();
        
        $this->mockedSimpleTimeWithoutSemicolumnValidator = $mockedSimpleTimeWithoutSemicolumnValidator;
        $serviceManager->setService('PbxAgi\Validator\Time\SimpleTimeWithoutSemicolumnValidator', $mockedSimpleTimeWithoutSemicolumnValidator);

        
         
        
        
        
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this->routeMatch->setParam('action', 'set');        
     }
/*
     public function test_alarm_setting_rejected_when_invoked_with_incorrect_parameters()
     {
         $this->mockedAppConfig->expects($this->any())
                               ->method('getAlarmWrongTimeFormat')
                               ->with()
                               ->will($this->returnValue('alarm/wrong_time_format'));
         
          
         $this->routeMatch->setParam('time', '2400');

         $this->mockedSimpleTimeWithoutSemicolumnValidator->expects($this->once())
                                                          ->method('isValid')
                                                          ->with('2400')
                                                          ->will($this->returnValue(false));
          
         
     	$mockedClient = $this->mockedAgi;
     	$mockedClient->assert('answer')
     	             ->assert('streamFile',array('silence/1'))
     	             ->assert('streamFile',array('alarm/wrong_time_format'))
     	             ->assert('streamFile',array('silence/1'))     	
     	             ->assert('hangup')
      	              
                     ->onAnswer(true)
                     ->onStreamFile(true)
                     ->onStreamFile(true)
                     ->onStreamFile(true)
                      
                     ->onHangup(true)
     	;
     	 
     	 
     
     	 
     	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
     }
     */
     public function test_alarm_is_set_up_correctly_when_invoked_with_correct_parameters()
     {
     
     	$this->routeMatch->setParam('time', '2300');
     
     	$this->mockedSimpleTimeWithoutSemicolumnValidator
     	     ->expects($this->any())
     	     ->method('isValid')
     	     ->with('2300')
     	     ->will($this->returnValue(true));

     	$extension = '300';

     	
     	$callSpoolImplOptions = array(
     			'tmpDir' => '/tmp',
     			'spoolDir' => '/var/spool/asterisk'
     	);
     	
     	$mockedCallSpoolImpl = $this->mockedCallSpoolImpl;
     	$mockedCallSpoolImplFactory = $this->mockedCallSpoolImplFactory;
     	$mockedCallSpoolImplFactory->expects($this->once())
     	                           ->method('getInstance')
     	                           ->with($callSpoolImplOptions)
     	                           ->will($this->returnValue($mockedCallSpoolImpl));
     	 
     	$this->mockedVarManager->expects($this->once())
     	                       ->method('getExten')
     	                       ->with()
     	                       ->will($this->returnValue('*50*2300'));
     	
     	$mockedPrepareCallControllerPlugin = $this->getMockBuilder('PbxAgi\Controller\Plugin\PrepareCallControllerPlugin')
     	                                          ->disableOriginalConstructor()
     	                                          ->getMock();
     	
     	$pluginManager = $this->pluginManager;
     	$this->mockedPrepareCallControllerPlugin = $mockedPrepareCallControllerPlugin;
     	$pluginManager->setService('PrepareCallControllerPlugin', $mockedPrepareCallControllerPlugin);
     	
     	 
     	
     	$mockedCallEntity = $this->getMockBuilder('PbxAgi\Entity\CallEntity')
     	                         ->disableOriginalConstructor()
     	                         ->getMock();
     	
     	
     	$mockedCallOriginator = $this->getMockBuilder('PbxAgi\Entity\CallOrignatorEntity')
     	                             ->disableOriginalConstructor()
     	                             ->getMock();
     	
     	
     	$mockedCallOriginator->expects($this->any())
     	                     ->method('getExtension')
     	                     ->with()
     	                     ->will($this->returnValue($extension));
     	
     	$callOriginator = new CallOriginatorEntity();
     	$callOriginator->setExtension($extension);
     	
     	$mockedCallEntity->expects($this->once())
     	                 ->method('getCallOriginator')
     	                 ->with()
     	                 ->will($this->returnValue($callOriginator));
     	
     	
     	
     	$mockedPrepareCallControllerPlugin->expects($this->once())
     	                                  ->method('initCall')
     	                                  ->with()
     	                                  ->will($this->returnValue($mockedCallEntity));
     	
     	$mockedSimpleTimeParser = $this->getMockBuilder('PbxAgi\Service\DialString\SimpleTimeParser')
     	                        ->disableOriginalConstructor()
     	                        ->getMock();
     	
     	$this->mockedSimpleTimeParser = $mockedSimpleTimeParser;
     	
     	$serviceManager = $this->serviceManager;
     	
     	$serviceManager->setService('PbxAgi\Service\DialString\SimpleTimeParser', $mockedSimpleTimeParser);
     	
     	$dtime = new \DateTime();
     	
     	$dtime->setTime(23, 0);
     	
     	$mockedSimpleTimeParser->expects($this->any())
     	                       ->method('__invoke')
     	                       ->with('2300')
     	                       ->will($this->returnValue($dtime));
      	

     	 
     	 
     	$dialDescriptor = new LocalDialDescriptor($extension, 'dialsipexten');
     	$callFile = new CallFile($dialDescriptor);
     	
     	$callFile->setContext('vpbx_alarmplay');
     	$callFile->setExtension($extension);
     	$callFile->setPriority(1);
     	$callFile->setMaxRetries(3);
     	$callFile->setWaitTime(2);
     	
     	
     	$mockedCallSpoolImpl = $this->mockedCallSpoolImpl;
     	
     	$mockedCallSpoolImpl->expects($this->once())
     	                    ->method('spool')
     	                    ->with($callFile,$dtime->getTimestamp())
     	                    ->will($this->returnValue(true));
     	 
     	$mockedAppConfig = $this->mockedAppConfig;
     	$mockedAppConfig->expects($this->once())
     	                    ->method('getTmpDir')
     	                    ->with()
     	                    ->will($this->returnValue('/tmp'));

     	
     	$mockedAppConfig->expects($this->once())
     	                    ->method('getAsteriskCallfileSpoolPath')
     	                    ->with()
     	                      ->will($this->returnValue('/var/spool/asterisk'));
     	$mockedAppConfig->expects($this->once())
     	                    ->method('getAlarmPlayContextName')
     	                    ->with()
     	                     ->will($this->returnValue('vpbx_alarmplay'));

     	$mockedAppConfig->expects($this->once())
     	                    ->method('getDialSipExtensionContextName')
     	                    ->with()
     	                    ->will($this->returnValue('dialsipexten'));
      	
     	
     	$mockedClient = $this->mockedAgi;
     	$mockedClient->assert('answer')
     	             ->assert('hangup')
     	             ->onAnswer(true)
     	             ->onHangup(true)
     	;
     	 
     	 
     	 
     	 
     	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
     }
     
     
}