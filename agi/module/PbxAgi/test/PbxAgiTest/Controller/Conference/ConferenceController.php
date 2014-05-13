<?php
namespace PbxAgiTest\Controller\Conference;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Controller\ConferenceControllerFactory;
use PbxAgi\Conference\Model\Conference;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\GeneralSettings\Model\GeneralSettings;

class ConferenceControllerTest extends AbstractControllerTestCase
{
   private $mockedClientImpl;
   protected $mockedConferenceTable;
   protected $mockedConferenceValidator;  
   protected $mockedCallOwnerEntity;
   protected $mockedCallOriginatorEntity;
   protected $mockedCallDestinatorEntity; 
   protected $mockedPrepareCallControllerPlugin;

      public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
        
        $mockedConferenceValidator = $this->getMockBuilder('PbxAgi\Conference\Model\ConferenceValidator')
                                          ->disableOriginalConstructor()
                                          ->getMock();
        $serviceManager->setService('PbxAgi\Conference\Model\ConferenceValidator', $mockedConferenceValidator);
        $this->mockedConferenceValidator = $mockedConferenceValidator;
        
        $mockedConferenceTable = $this->getMockBuilder('PbxAgi\Conference\Model\ConferenceTable')
                                      ->disableOriginalConstructor()
                                      ->getMock();
        $serviceManager->setService('PbxAgi\Conference\Model\ConferenceTable', $mockedConferenceTable);
        $this->mockedConferenceTable = $mockedConferenceTable;
        
        
        
        $mockedCallEntity =  $this->getMockBuilder('PbxAgi\Entity\CallEntity')
        ->disableOriginalConstructor()
        ->getMock();
                
        
        $serviceManager->setService('CallEntity', $mockedCallEntity);
        
        
        $mockedCallOwnerEntity =  $this->getMockBuilder('PbxAgi\Entity\CallOwnerEntity')
                                       ->disableOriginalConstructor()
                                       ->getMock();
        
        $mockedCallOriginatorEntity =  $this->getMockBuilder('PbxAgi\Entity\CallOriginatorEntity')
                                            ->disableOriginalConstructor()
                                            ->getMock();
        
        $this->mockedCallOriginatorEntity = $mockedCallOriginatorEntity;
        
        $mockedCallDestinatorEntity =  $this->getMockBuilder('PbxAgi\Entity\CallDestinatorEntity')
                                            ->disableOriginalConstructor()
                                            ->getMock();
        
        
        $mockedCallEntity->expects($this->any())
                                            ->method('getCallOwner')
                                            ->with()
                                            ->will($this->returnValue($mockedCallOwnerEntity));
        
        
        $mockedCallEntity->expects($this->any())
                                            ->method('getCallOriginator')
                                            ->with()
                                            ->will($this->returnValue($mockedCallOriginatorEntity));
        
        
        $mockedCallEntity->expects($this->any())
                                            ->method('getCallDestinator')
                                            ->with()
                                            ->will($this->returnValue($mockedCallDestinatorEntity));
        
        $this->mockedClientImpl = new MockedClientImpl(array());         
        $serviceManager->setService('ClientImpl', $this->mockedClientImpl);   
        
        $mockedGeneralSettings =  $this->getMockBuilder('PbxAgi\GeneralSettings\Model\GeneralSettingsTable')
                                            ->disableOriginalConstructor()
                                            ->getMock();
        
        $serviceManager->setService('PbxAgi\GeneralSettings\Model\GeneralSettingsTable', $mockedGeneralSettings);

        $generalsettings = new GeneralSettings();
        
        $data = array(
        	'vpbxid'=>1,
            'vmtimeout'=>5,
            'greeting'=>3,
            'mohtone'=>4,
            'ringingtome'=>3,
            'mediarepospath'=>'/var/spool/asterisk/mediarepos',
            'mohinternal'=>true
        );
        $generalsettings->exchangeArray($data);        
        
        $mockedCallEntity->expects($this->any())
                         ->method('getSettings')
                         ->with(1)
                         ->will($this->returnValue($generalsettings));

        
        $factory = new ConferenceControllerFactory();
        
        $this->controller = $factory->createService($serviceManager);
        
         
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'PbxAgi\Controller\ConferenceController'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

       
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this-> controller->getPluginManager()->setServiceLocator($serviceManager);

        $mockedPrepareCallControllerPlugin =  $this->getMockBuilder('PbxAgi\Controller\Plugin\PrepareCallControllerPlugin')
                                  ->disableOriginalConstructor()
                                  ->getMock();
        
        $this->controller->getPluginManager()
                         ->setService('PrepareCallControllerPlugin', $mockedPrepareCallControllerPlugin);
        
        $this->mockedPrepareCallControllerPlugin = $mockedPrepareCallControllerPlugin;
        
     }
     
   public function test_can_create_new_conference()
   {
       \Logger::shutdown();
       $this->routeMatch->setParam('action', 'create');        

       $mockedConferenceTable = $this->mockedConferenceTable;
       
       $conference = new Conference();
       $data = array(
           'id'=>100,
           'custname'=>'',
           'custdesc'=>'',
           'confnumber'=>'1234',
           'ownertype'=>'EXTENSION',
           'ownerref'=>10,
           'isprotected'=>true,
           'pin'=>'1234',
           'websecret'=>'',
           'maxmembers'=>255,
           'memberspresent'=>0,
           'datecreated'=>'2014-01-01 12:00:01',
           'datesettoexpiry'=>'2014-01-02 12:00:01',
           'datefirstentered'=>'2014-01-01 12:00:01',
           'createdfrom'=>'WEBUI',
           'ispstnallowed'=>true,
           'vpbxnum'=>1,
           'lastentered'=>'2014-01-01 12:00:01',
           'joinacl'=>'ALL'
       );
       $conference->exchangeArray($data);
       
        
       $mockedConferenceTable->expects($this->once())
                             ->method('getConferenceById')
                             ->with()
                             ->will($this->returnValue($conference));
         
        
       $this->mockedClientImpl->assert('answer')
                    ->assert('streamFile', array("silence/1", "0123456789*#"))
                    ->assert('streamFile', array("conf-getconfno", "0123456789*#"))                    
                    ->assert('waitDigit')       
                    ->assert('waitDigit')
                    ->assert('waitDigit')             
                    ->assert('streamFile', array("silence/1", "0123456789*#"))
                    ->assert('streamFile', array("conf-select-scope", "0123456789*#"))
                    ->assert('streamFile', array("silence/1", "0123456789*#"))
                    ->assert('streamFile', array("conf-getpin", "0123456789*#"))
                    ->assert('sayDigits', array("1234"))
                    ->assert('streamFile', array("silence/1"))
                    ->assert('sayDigits', array("1234"))                    
                    ->assert('streamFile', array("silence/1"))
                    ->onAnswer(true)
                    ->onStreamFile(false)
                    ->onStreamFile(true,"1")
                    ->onWaitDigit(true,"2")
                    ->onWaitDigit(true,"3")
                    ->onWaitDigit(true,"4")
                    ->onStreamFile(false)
                    ->onStreamFile(true,"1")
                    ->onStreamFile(false)
                    ->onStreamFile(true,"*")
                    ->onSayDigits(true)
                    ->onStreamFile(false)
                    ->onSayDigits(true)
                    ->onStreamFile(false)
                    ->addMockedResult('200 result=0')
                    
      ;   
        
       
          
       $result   = $this->controller->dispatch($this->request);
       $response = $this->controller->getResponse();
   }   
   /*
   public function test_can_join_existing_conference()
   {
   	$this->mockedClientImpl->__destruct();
   
   	 
   	$this->routeMatch->setParam('action', 'join');
   	 
   	$mockedConferenceValidator = $this->mockedConferenceValidator;
   	 
   	$mockedConferenceValidator->expects($this->any())
   	->method('isValid')
   	->with('1234')
   	->will($this->returnValue(false));
   	 
   	$peer = new Extension();
   	$peer->peertype = 'EXTENSION';
   	$this->mockedCallOriginatorEntity->expects($this->any())
   	->method('getPeer')
   	->with('1234')
   	->will($this->returnValue($peer));
   
   
   	$this->mockedClientImpl->assert('answer')
   	->assert('streamFile', array("conf-getconfno", "0123456789*#"))
   
   	->onAnswer(true)
   	->onStreamFile(true,'1')
   	->onStreamFile(true,'1')
   	->onStreamFile(true,'1')
   
   	;
   
   	$result   = $this->controller->dispatch($this->request);
   	$response = $this->controller->getResponse();
   
   }*/
}
