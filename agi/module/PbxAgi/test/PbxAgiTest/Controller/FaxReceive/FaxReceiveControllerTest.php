<?php
namespace PbxAgiTest\Controller\FaxReceive;

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

class FaxReceiveControllerTest extends AbstractControllerTestCase
{
     protected $mockedForward;
     protected $mockedfFeatureTable;
     protected $mockedVarManager;
     protected $mockedAgi;
     protected $mockedFaxSpoolTable;
     protected $mockedSendEmail;
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
                        ->method('getFaxReceiveSpoolDir')
                        ->with()
                        ->will($this->returnValue('/var/spool/asterisk/fax'));
        
        $mockedAppConfig->expects($this->any())
                         ->method('getFaxReceiveOptions')
                         ->with()
                         ->will($this->returnValue('ds'));
        
        $mockedAppConfig->expects($this->any())
                        ->method('getFaxReceiveNumTries')
                        ->with()
                        ->will($this->returnValue(3));
         
        $mockedAppConfig->expects($this->any())
                        ->method('getFaxReceiveMessageFromAddress')
                        ->with()
                        ->will($this->returnValue('kartemiev@gmail.com'));
         
        $mockedAppConfig->expects($this->any())
                        ->method('getFaxReceiveMessageTo')
                        ->with()
                        ->will($this->returnValue('kartemiev@gmail.com'));
         
 
        $this->mockedVarManager =  $this->getMockBuilder('PbxAgi\Service\ChannelVarManager\ChannelVarManager')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        $serviceManager->setService('ChannelVarManager', $this->mockedVarManager);

        
        $this->mockedFaxSpoolTable =  $this->getMockBuilder('PbxAgi\FaxSpool\Model\FaxSpoolTable')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        $serviceManager->setService('PbxAgi\FaxSpool\Model\FaxSpoolTable', $this->mockedFaxSpoolTable);
        
        
        $this->mockedSendEmail =  $this->getMockBuilder('PbxAgi\Service\SendEmail\SendEmail')
        									   ->disableOriginalConstructor()
        									   ->getMock();
        $serviceManager->setService('PbxAgi\Service\SendEmail\SendEmail', $this->mockedSendEmail);
        
        $this->mockedAgi = new MockedClientImpl(array());
        $serviceManager->setService('ClientImpl', $this->mockedAgi);
        
        
        
        $faxReceiveControllerFactory = new FaxReceiveControllerFactory();
        $this->controller = $faxReceiveControllerFactory->createService($serviceManager);

        
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'receive'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
  
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this->routeMatch->setParam('action', 'Receive');
        
     }
    
      
     public function test_fax_controller_can_store_fax_result_data()
     {
     	$appConfig = $this->controller->getServiceLocator()
     					 ->get('AppConfig');
     	$mockedClient = $this->mockedAgi;
     	$mockedClient
         	->assert('getFullVariable',array('CALLERID(name)'))
         	->assert('getFullVariable',array('CALLERID(num)'))
         	->assert('getFullVariable',array('CALLERID(num)'))
         	->assert('getFullVariable',array('CALLERID(name)'))                  	
          	->assert('answer')    
          	->assert('getFullVariable',array('FAXSTATUS'))
          	->assert('getFullVariable',array('FAXBITRATE'))
          	->assert('getFullVariable',array('FAXRESOLUTION'))
          	->assert('getFullVariable',array('FAXPAGES'))
          	->assert('getFullVariable',array('FAXERROR'))
          	->assert('getFullVariable',array('REMOTESTATIONID'))
          	->assert('getFullVariable',array('LOCALSTATIONID'))
          	->assert('getFullVariable',array('LOCALHEADERINFO'))
            
            ->onGetFullVariable(true,'74956408040')
            ->onGetFullVariable(true,'74956408040')
            ->onGetFullVariable(true,'74956408040')
            ->onGetFullVariable(true,'74956408040')            
            ->onAnswer(true)            
     	             ->addMockedResult("200 result=0")
     	             ->onGetFullVariable(true,'SUCCESS')     	   
     	             ->onGetFullVariable(true,'14400')
     	             ->onGetFullVariable(true,'300')
     	             ->onGetFullVariable(true,'3')     	              
     	             ->onGetFullVariable(true,'0')
     	             ->onGetFullVariable(true,'4956408040')
     	             ->onGetFullVariable(true,'4956408040')
     	             ->onGetFullVariable(true,'')
     	              
       	;
     	$callerId = new CallerIdFacade($this->mockedAgi);
     	$callerId->setNumber('74956408040');
     	$callerId->setName('74956408040');
     	
     	$this->mockedVarManager->expects($this->once())
     						   ->method('getUnqieId')
     						   ->will($this->returnValue("1252500374.335"));

		$this->mockedVarManager->expects($this->once())
     						   ->method('getCallerId')
     						   ->will($this->returnValue($callerId));   
		  						   
     	$this->mockedVarManager->expects($this->once())
     						   ->method('getCallerId')
     						   ->will($this->returnValue("74956408040"))
     						   
     	;
     	
    
     	
     	$this->mockedFaxSpoolTable->expects($this->any())
     							  ->method('saveFax')     	
      							  ->will($this->returnValue(1));
      
     	
     	$cidName = '74956408040';
     	$cidNumber = '74956408040';
     	 
     	$mockedSendEmail = $this->mockedSendEmail;
     	 
      	$emailmessage = new EmailMessage();
     	$emailmessage->exchangeArray(array(
     			'parameters'=>array(
     					'cidName'=>$cidName,
     					'cidNumber'=>$cidNumber
     			),
     			'templatehtml' => 'mailTemplateHtml',
     			'templateplain' => 'mailTemplatePlain',
     			'layoutplain' => 'mailLayoutPlain',     			
     			'layouthtml' => 'mailLayoutHtml',
     			'attachments' => array(
     					array('path'=>'/var/spool/asterisk/fax/1.tiff', 'type'=>'image/tiff')),
     			'msgfromemail'=>$appConfig->getFaxReceiveMessageFromAddress(),
     			'msgfromfullname'=>$appConfig->getFaxReceiveMessageFromAddress(),
     			'msgto'=>$appConfig->getFaxReceiveMessageTo(),
     			'msgsubject'=>FaxReceiveController::EMAIL_SUBJECT
     	)
     	);
     	$mockedSendEmail->expects($this->once())->method('send')
     					->with($emailmessage)
     					->will($this->returnValue(true));
     	     	     	
     	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
     }
    
}