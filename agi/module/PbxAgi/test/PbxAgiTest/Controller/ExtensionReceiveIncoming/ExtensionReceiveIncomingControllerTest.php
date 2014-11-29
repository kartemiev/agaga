<?php
namespace PbxAgiTest\Controller\ExtensionReceiveIncoming;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use PbxAgi\Controller\ExtensionReceiveIncomingControllerFactory;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PbxAgi\Controller\Plugin\MockedRedirector;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Extension\Model\Extension;  
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;   
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\CallDestination\Model\CallDestination;
use PbxAgi\GeneralSettings\Model\GeneralSettings;

class ExtensionReceiveIncomingControllerTest extends AbstractControllerTestCase
{
   private $mockedClientImpl;
   private $mockedPrepareCallControllerPlugin;
   private $serviceManager;
   private $mockedExtensionTable;
   private $mockedRedirectorControllerPlugin;
   private $mockedVarManager;
   private $mockedCallDestinationTable;
   private $mockedFeatureCheckPermissionPlugin;
   private $mockedRecordCallControllerPlugin;
      public function setUp()
    {
        \Logger::shutdown();
        
         $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);
        $this->serviceManager = $serviceManager;         
        $this->mockedClientImpl = new MockedClientImpl(array()); 

        $this->mockedClientImpl
        	 ->assert('getVariable', array("EXTEN"))
        	 ->onGetVariable(true, '500');
        
        $serviceManager->setService('ClientImpl', $this->mockedClientImpl);   
         
        
        
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
                        ->method('getVpbxDialoutContextName')
                        ->with()
                        ->will($this->returnValue('vpbx_dialout'));
        
        $generalSettings = new GeneralSettings();
        
        $generalSettings->ringingtone = '1';
        
        $mockedAppConfig->expects($this->any())
                        ->method('getGeneralSettings')
                        ->with()
                        ->will($this->returnValue($generalSettings));
        
        
        
        $mockedVarManager = $this->getMockBuilder('PbxAgi\Service\ChannelVarManager\ChannelVarManager')
        						 ->disableOriginalConstructor()
        						 ->getMock();
        $this->mockedVarManager = $mockedVarManager;
        $serviceManager->setService('ChannelVarManager', $mockedVarManager);
        $mockedExtensionTable = $this->getMockBuilder('PbxAgi\Extension\Model\ExtensionTable')
                                     ->disableOriginalConstructor()
                                     ->getMock();
        $serviceManager->setService('ExtensionTable', $mockedExtensionTable);
        
        $this->mockedExtensionTable = $mockedExtensionTable;

        
        $mockedCallDestinationTable = $this->getMockBuilder('PbxAgi\CallDestination\Model\CallDestinationTable')
        								   ->disableOriginalConstructor()
        								   ->getMock();
        $serviceManager->setService('PbxAgi\CallDestination\Model\CallDestinationTable', $mockedCallDestinationTable);
        
        $this->mockedCallDestinationTable = $mockedCallDestinationTable;        
        
        
        $dialOutControllerFactory = new ExtensionReceiveIncomingControllerFactory();
        $this->controller = $dialOutControllerFactory->createService($serviceManager);
        
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
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
        
        $mockedPrepareCallControllerPlugin = 
        $this->getMockBuilder('PbxAgi\Controller\Plugin\PrepareCallControllerPlugin')
        	 ->disableOriginalConstructor()
        	 ->getMock();
        
        $this->mockedPrepareCallControllerPlugin = $mockedPrepareCallControllerPlugin;
        
        
        $mockedRecordCallPlugin =
        $this->getMockBuilder('PbxAgi\Controller\Plugin\RecordCallControllerPlugin')
             ->disableOriginalConstructor()
             ->getMock();
        
        
        $pluginManager->setService('RecordCallPlugin', $mockedRecordCallPlugin);
        
        $this->mockedRecordCallControllerPlugin = $mockedRecordCallPlugin;
         
        
        $pluginManager->setService('PrepareCallControllerPlugin', $mockedPrepareCallControllerPlugin);        
        
         
        $mockedRedirectorControllerPlugin =
        $this->getMockBuilder('PbxAgi\Controller\Plugin\RedirectorControllerPlugin')
        ->disableOriginalConstructor()
        ->getMock();
        
        $this->mockedRedirectorControllerPlugin = $mockedRedirectorControllerPlugin;                
        $pluginManager->setService('RedirectorControllerPlugin', $mockedRedirectorControllerPlugin);
        
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    	$this->routeMatch->setParam('action', 'Index');
    	 
    	$mockedAgi = $this->mockedClientImpl;
    	    	 
	   $this->mockedVarManager->expects($this->any())
      	->method('setupRecordFilename')
       	->will($this->returnValue(null));
          	
      }
      
      public function populateCallWithTestData($data)
      {
      	$call = $this->serviceManager->get('CallEntity');     	 
      	$extensionRecord = new Extension();
      	$hydrator = new Hydrator(false);
      	$data = array_merge(array(
      			'id'=>140,
      			'extension' => "500",
      			'name'=>'500',
      			'extensiontype'=>'OPERATOR',      			 
      			'diversion_unconditional_status'=>'DISABLED', 
      			'mailbox'=> '500',     			 
       	), $data);
       	$hydrator->hydrate($data, $extensionRecord);
      	 
      	$call->setCallDestinator($extensionRecord);
      	$call->setExten('500');
      
      	$this->mockedExtensionTable->expects($this->any())
      	->method('getExtension')
      	->with('500')
      	->will($this->returnValue($extensionRecord));
      
      	 
      	
      	$this->mockedPrepareCallControllerPlugin->expects($this->any())
      	->method('initCall')
      	->will($this->returnValue($call));
       	
   
      	
      	$this->mockedFeatureCheckPermissionPlugin->expects($this->any())
      	->method('__invoke')
       	->will($this->returnValue(true));
      	
      	 
      	
      	$result   = $this->controller
      					 ->dispatch($this->request);
      	$response = $this->controller
      					 ->getResponse();
      	;      	      	
      }
      
    public function test_regular_processing()
    {
    	$resultSet = array();
    	$this->mockedCallDestinationTable->expects($this->once())
    	->method('fetchAll')
    	->with(array('peerid'=>140))
    	->will($this->returnValue($resultSet));
    	
     	
        $mockedAgi = $this->mockedClientImpl;
         $mockedAgi
           ->assert('dial',array('SIP/500',array(null,'m(1_ringingtone)Tt')))           
          ->onDial(true, 'name', 'number', '20', 'ANSWER', '#asd');          
         
         $data = array(
          );
         $this->populateCallWithTestData($data);         
            
    }

    
    
    public function test_group_calling_sequential_processing()
    {
    	$callDestination = new CallDestination();
    	$callDestination->exchangeArray(array('peerid'=>'140','number'=>'100','duration'=>10));    	     	
    	$resultSet[] = $callDestination;
    	
    	$callDestination = new CallDestination();
    	$callDestination->exchangeArray(array('peerid'=>140, 'number'=>'200','duration'=>20));
    	$resultSet[] = $callDestination;
    	 
    	
    	$this->mockedCallDestinationTable->expects($this->once())
    	->method('fetchAll')
    	->with(array('peerid'=>140))
    	->will($this->returnValue($resultSet));
    	
    	$mockedAgi = $this->mockedClientImpl;
    	$mockedAgi
    	->assert('dial',array('Local/100@vpbx_dialout',array(10,"m(1_ringingtone)Tt")))
    	->assert('dial',array('Local/200@vpbx_dialout',array(20,"m(1_ringingtone)Tt")))    	 
    	->onDial(true, 'name', 'number', '10', 'BUSY', '#asd')
    	->onDial(true, 'name', 'number', '20', 'ANSWER', '#asd');    	 
    	
    	$data = array(
    			'callsequence'=>AppConfigInterface::DB_CALLSEQUENCE_RECORDTYPE_SEQUENTIAL
    	);
    	$this->populateCallWithTestData($data);
    	
    }

    
    public function test_group_calling_simulring_processing()
    {
    	$callDestination = new CallDestination();
    	$callDestination->exchangeArray(array('peerid'=>'140','number'=>'100'));
    	$resultSet[] = $callDestination;
    	 
    	$callDestination = new CallDestination();
    	$callDestination->exchangeArray(array('peerid'=>140, 'number'=>'200'));
    	$resultSet[] = $callDestination;
    
    	$callDestination = new CallDestination();
    	$callDestination->exchangeArray(array('peerid'=>140, 'number'=>'500'));
    	$resultSet[] = $callDestination;
    	 
    	$this->mockedCallDestinationTable->expects($this->once())
    	->method('fetchAll')
    	->with(array('peerid'=>140))
    	->will($this->returnValue($resultSet));
    	 
    	$mockedAgi = $this->mockedClientImpl;
    	$mockedAgi->assert('dial',array('Local/100@vpbx_dialout&Local/200@vpbx_dialout&SIP/500',array(null,"m(1_ringingtone)Tt")))
     	          ->onDial(true, 'name', 'number', '20', 'ANSWER', '#asd');
    	 
    	$data = array(
    			'callsequence'=>AppConfigInterface::DB_CALLSEQUENCE_RECORDTYPE_SIMULRING
    	);
    	$this->populateCallWithTestData($data);
    	    	 
    }
    
    public function test_regular_processing_typefax()
    {   
    
    	$this->mockedRedirectorControllerPlugin->expects($this->once())
    	->method('dispatch')
    	->with('/faxreceive/receive/500')
    	->will($this->returnValue(null));
    	     	
    	$data = array(
    			'extensiontype'=>'fax',
     	);
    	 
    	$this->populateCallWithTestData($data);    	     	 
    }
    
    public function test_unconditional_diversion_numberlading_processing()
    {
    	$mockedAgi = $this->mockedClientImpl;
    	$mockedAgi
    	->assert('dial',array('Local/89251999108@vpbx_dialout',array(60,"m(1_ringingtone)Tt")))
    	->assert('hangup')    	     	 
    	->onDial(true, 'name', 'number', '20', 'ANSWER', '#asd')
    	->onHangup(true);

    	$data = array(
     			'diversion_unconditional_status'=>'ACTIVATED',
    			'diversion_unconditional_number'=>'89251999108',
    			'diversion_unconditional_landingtype'=>'NUMBER',
    	);
    	    	 
    	$this->populateCallWithTestData($data);	     	 
    }
    
    public function test_unconditional_diversion_voicemail_landing_processing()
    {
    	$this->mockedVarManager->expects($this->once())
    	->method('voiceMail')
    	->with('500@default')
    	->will($this->returnValue(true));
    	
    	$mockedAgi = $this->mockedClientImpl;
    	$mockedAgi
     	->assert('hangup')
     	->onHangup(true);
    
    	$data = array(
     			'diversion_unconditional_status'=>'ACTIVATED',
    			'diversion_unconditional_landingtype'=>'VOICEMAIL',
    	);
    	 
    	$this->populateCallWithTestData($data);
    }
    
    public function test_unconditional_diversion_fax_landing_processing()
    {
    	$this->mockedRedirectorControllerPlugin->expects($this->once())
    	->method('dispatch')
    	->with('/faxreceive/receive/500')
    	->will($this->returnValue(null));
    	 
    	$data = array(
    			'diversion_unconditional_status'=>'ACTIVATED',
    			'diversion_unconditional_landingtype'=>'FAX',
    	);
    	$mockedAgi = $this->mockedClientImpl;
    	$mockedAgi
    	->assert('hangup')
    	->onHangup(true);
    	$this->populateCallWithTestData($data);    	     
    }         
    
    public function test_busy_diversion_processing()
    {
    	$resultSet = array();
    	$this->mockedCallDestinationTable->expects($this->once())
    	->method('fetchAll')
    	->with(array('peerid'=>140))
    	->will($this->returnValue($resultSet));
    	
    	$mockedAgi = $this->mockedClientImpl;
    	$mockedAgi
    	->assert('dial',array('SIP/500',array(null,'m(1_ringingtone)Tt')))
    	->assert('dial', array('Local/89251999108@vpbx_dialout',array(60,"m(1_ringingtone)Tt")))
    	->assert('hangup')
      	->onDial(true, 'name', 'number', '20', 'BUSY', '#asd')
    	->onDial(true, 'name', 'number', '20', 'ANSWER', '#asd')
    	->onHangup(true);
    	 
    	
    	$data = array(
    			'diversion_busy_status'=>'ACTIVATED',
    			'diversion_busy_number'=>'89251999108',
    			'diversion_busy_landingtype'=>'NUMBER',
    	);
    	 
    	$this->populateCallWithTestData($data);
    	    	 
    }
    public function test_noanswer_diversion_processing_number()
    {
    	
    	$resultSet = array();
    	$this->mockedCallDestinationTable->expects($this->once())
    	->method('fetchAll')
    	->with(array('peerid'=>140))
    	->will($this->returnValue($resultSet));
    	
    	
    	$mockedAgi = $this->mockedClientImpl;
    	$mockedAgi
    	->assert('dial',array('SIP/500',array(null,'m(1_ringingtone)Tt')))
    	->assert('dial', array('Local/89251999108@vpbx_dialout',array(60,"m(1_ringingtone)Tt")))
    	->assert('hangup')
    	->onDial(true, '500', '500', '20', 'NOANSWER', '')
    	->onDial(true, 'name', 'number', '10', 'ANSWER', '')
    	->onHangup(true);
    
    	$data = array(
    			'diversion_noanswer_status'=>'ACTIVATED',
    			'diversion_noanswer_number'=>'89251999108',
    			'diversion_noanswer_landingtype'=>'NUMBER',
    	);
    	 
    	$this->populateCallWithTestData($data);
    }   

    
    public function test_noanswer_diversion_processing_voicemail()
    {
    	 
    	$resultSet = array();
    	$this->mockedCallDestinationTable->expects($this->once())
    	->method('fetchAll')
    	->with(array('peerid'=>140))
    	->will($this->returnValue($resultSet));
    	 
    	 
    	$mockedAgi = $this->mockedClientImpl;
    	$mockedAgi
    	->assert('dial',array('SIP/500',array(null,'m(1_ringingtone)Tt')))
    	->assert('hangup')
    	->onDial(true, '500', '500', '20', 'NOANSWER', '')
    	->onHangup(true);
    	$this->mockedVarManager->expects($this->once())
    	->method('voiceMail')
    	->with('500@default')
    	->will($this->returnValue(true));
    	 
     	$data = array(
    			'diversion_noanswer_status'=>'ACTIVATED',
    			'diversion_noanswer_number'=>'89251999108',
    			'diversion_noanswer_landingtype'=>'VOICEMAIL',
    	);
    
    	$this->populateCallWithTestData($data);
    }
    
     
    
    public function test_chanunavail_processing()
    {
    	$resultSet = array();
    	$this->mockedCallDestinationTable->expects($this->once())
    	->method('fetchAll')
    	->with(array('peerid'=>140))
    	->will($this->returnValue($resultSet));
    	
    	$mockedAgi = $this->mockedClientImpl;
    	$mockedAgi
    	->assert('dial',array('SIP/500',array(null,'m(1_ringingtone)Tt')))
    	->assert('dial', array('Local/89251999108@vpbx_dialout',array(60,"m(1_ringingtone)Tt")))
    	->assert('hangup')
    	->onDial(true, '500', '500', '20', 'CHANUNAVAIL', '')
    	->onDial(true, 'name', 'number', '10', 'ANSWER', '')
    	->onHangup(true);
    
    
    	$data = array(
    			'diversion_unavail_status'=>'ACTIVATED',
    			'diversion_unavail_number'=>'89251999108',
    			'diversion_unavail_landingtype'=>'NUMBER',
    	);    	 
    	$this->populateCallWithTestData($data);
    	 
    }
    public function test_hangup_when_destination_blocked()
    {


        $this->mockedFeatureCheckPermissionPlugin->expects($this->any())
        ->method('__invoke')
        ->with('number_status',array('ACTIVE','UNDEFINED'),'CallDestinator')
        ->will($this->returnValue(false));
    
    	$call = $this->serviceManager->get('CallEntity');
    	$extensionRecord = new Extension();
    	$hydrator = new Hydrator(false);
    	$data = array(
    			'diversion_unavail_status'=>'ACTIVATED',
    			'diversion_unavail_number'=>'89251999108',
    			'diversion_unavail_landingtype'=>'NUMBER',
    	);
    	 
    	$data = array_merge(array(
    			'id'=>140,
    			'extension' => 500,
    			'name'=>'500',
    			'extensiontype'=>'OPERATOR',
    			'diversion_unconditional_status'=>'DISABLED',
    			'mailbox'=> '500',
    	), $data);
    	$hydrator->hydrate($data, $extensionRecord);
    	
    	$call->setCallDestinator($extensionRecord);
    	$call->setExten('500');
    	
    	$this->mockedExtensionTable->expects($this->any())
    	->method('getExtension')
    	->with('500')
    	->will($this->returnValue($extensionRecord));
    	 
    	$this->mockedPrepareCallControllerPlugin->expects($this->any())
    	->method('initCall')
    	->will($this->returnValue($call));
    	    	 
      	$this->assertFalse($this->controller
      					 ->dispatch($this->request));
      	$response = $this->controller
      					 ->getResponse();
      	;      	      	
    	    
    }
    public function test_when_extension_not_found()
    {
        $mockedAgi = $this->mockedClientImpl;
        $mockedAgi->assert('hangup')
                  ->onHangup(true);
        
    	$this->mockedFeatureCheckPermissionPlugin->expects($this->any())
    	->method('__invoke')
    	->with('number_status',array('ACTIVE','UNDEFINED'),'CallDestinator')
    	->will($this->returnValue(false));
    
    	$call = $this->serviceManager->get('CallEntity');

    	$call->setExten('500');
    	 
    	$this->mockedExtensionTable->expects($this->once())
    	->method('getExtension')
    	->with('500')
    	->will($this->returnValue(null));
    
    	$this->mockedPrepareCallControllerPlugin->expects($this->once())
    	->method('initCall')
    	->will($this->returnValue($call));
    	 
    	$this->assertNull($this->controller
    			->dispatch($this->request));
    	$response = $this->controller
    	->getResponse();
    	;
    		
    }
    
     
    
}