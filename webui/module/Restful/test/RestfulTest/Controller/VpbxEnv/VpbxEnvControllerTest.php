<?php
namespace Restful\Controller {
    use RestfulTest\Controller\VpbxEnv\VpbxEnvControllerTest;
    function rename($oldname, $newname) {
        return VpbxEnvControllerTest::$functions->rename($oldname, $newname);
    }
}

namespace RestfulTest\Controller\VpbxEnv { 

use \RestfulTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;
use Restful\Controller\VpbxEnvControllerFactory;
use Zend\Http\Response;
use Saas\WizardSessionContainer\WizardSessionContainer;
use Saas\VpbxEnv\Model\VpbxEnv;
use Vpbxui\GeneralSettings\Model\GeneralSettings;
use Saas\TempMedia\Model\TempMedia;
use Vpbxui\MediaRepos\Model\MediaRepos;
use \Mockery as m;
use Vpbxui\Trunk\Model\Trunk;
use Vpbxui\Ivr\Model\Ivr;
use Vpbxui\TrunkAssoc\Model\TrunkAssoc;
use Vpbxui\Extension\Model\Extension;
use Vpbxui\ExtensionGroup\Model\ExtensionGroup;
use Saas\Did\Model\Did;
use Vpbxui\NumberMatch\Model\NumberMatch;
use Vpbxui\RegEntry\Model\RegEntry;
use Vpbxui\Route\Model\Route;
use Vpbxui\TrunkDestination\Model\TrunkDestination;
use Vpbxui\CallCentreSchedule\Model\CallCentreSchedule;

 

class VpbxEnvControllerTest extends \PHPUnit_Framework_TestCase
{
	private $controller;
	private $request;
	private $response;
	private $routeMatch;
	private $event;
	private $mockedWizardSessionContainer;
	private $mockedExtensionTable;
	private $mockedVpbxEnvTable;
	private $mockedMediaReposTable;
	private $mockedGeneralSettingsTable;
	private $mockedVpbxidProvider;
	private $mockedTrunkTable;
	private $mockedTrunkAssocTable;
	private $mockedContextTable;
	private $mockedIvrTable;
	private $mockedContext;
	private $mockedExtensionGroupTable;
	private $mockedExtension;
	private $mockedAdapter;
	private $mockedRouteTable;
	private $mockedRegEntryTable;
	private $mockedNumberMatchTable;
	private $mockedTrunkDestinationTable;
	private $mockedCallCentreScheduleTable;
	private $mockedGeneralSettings;
	private $mockedDbAdapter;
	private $context;
	public static $functions;
	
 
	
 	protected function setUp()
	{
		$serviceManager = Bootstrap::getServiceManager();
		
		$factory = new VpbxEnvControllerFactory();
		
		$this->mockedWizardSessionContainer = new WizardSessionContainer();
		
		$serviceManager->setService('Saas\WizardSessionContainer\WizardSessionContainer', $this->mockedWizardSessionContainer);

		$this->mockedExtensionTable = $this->getMockBuilder('Vpbxui\Extension\Model\ExtensionTable')
											->disableOriginalConstructor()
										    ->getMock();
		$serviceManager->setService('Vpbxui\Extension\Model\ExtensionTable', $this->mockedExtensionTable);
		
		$this->mockedVpbxEnvTable = $this->getMockBuilder('Saas\VpbxEnv\Model\VpbxEnvTable')
										 ->disableOriginalConstructor()
										 ->getMock();
		$serviceManager->setService('Saas\VpbxEnv\Model\VpbxEnvTable', $this->mockedVpbxEnvTable);
		
		$this->mockedMediaReposTable = $this->getMockBuilder('Vpbxui\MediaRepos\Model\MediaReposTable')
											->disableOriginalConstructor()
											->getMock();
		$serviceManager->setService('Vpbxui\MediaRepos\Model\MediaReposTable', $this->mockedMediaReposTable);
		
		$this->mockedGeneralSettingsTable = $this->getMockBuilder('Vpbxui\GeneralSettings\Model\GeneralSettingsTable')
												->disableOriginalConstructor()
												->getMock();
		$serviceManager->setService('Vpbxui\GeneralSettings\Model\GeneralSettingsTable', $this->mockedGeneralSettingsTable);
		
		
		$this->mockedVpbxidProvider = $this->getMockBuilder('Vpbxui\Service\VpbxidProvider\VpbxidProvider')
											->disableOriginalConstructor()
											->getMock();
		$serviceManager->setService('Vpbxui\Service\VpbxidProvider\VpbxidProvider', $this->mockedVpbxidProvider);
		

		$this->mockedTrunkTable = $this->getMockBuilder('Vpbxui\Trunk\Model\TrunkTable')
											->disableOriginalConstructor()
											->getMock();
		$serviceManager->setService('Vpbxui\Trunk\Model\TrunkTable', $this->mockedTrunkTable);
		
		$this->mockedTrunkAssocTable = $this->getMockBuilder('Vpbxui\TrunkAssoc\Model\TrunkAssocTable')
											->disableOriginalConstructor()
											->getMock();
		$serviceManager->setService('Vpbxui\TrunkAssoc\Model\TrunkAssocTable', $this->mockedTrunkAssocTable);

		
		$this->mockedContextTable = $this->getMockBuilder('Vpbxui\Context\Model\ContextTable')
										->disableOriginalConstructor()
										->getMock();

		$serviceManager->setService('Vpbxui\Context\Model\ContextTable', $this->mockedContextTable);

				
		
		
		$this->mockedIvrTable = $this->getMockBuilder('Vpbxui\Ivr\Model\IvrTable')
									 ->disableOriginalConstructor()
									->getMock();
		$serviceManager->setService('Vpbxui\Ivr\Model\IvrTable', $this->mockedIvrTable);
		
		
		$this->mockedContext = $this->getMockBuilder('Vpbxui\Context\Model\Context')
									->disableOriginalConstructor()
									->getMock();
		$serviceManager->setService('Vpbxui\Context\Model\Context', $this->mockedContext);
		
		
		$this->mockedExtensionGroupTable = $this->getMockBuilder('Vpbxui\ExtensionGroup\Model\ExtensionGroupTable')
												->disableOriginalConstructor()
												->getMock();
		$serviceManager->setService('Vpbxui\ExtensionGroup\Model\ExtensionGroupTable', $this->mockedExtensionGroupTable);
		
		
		$this->mockedExtension = $this->getMockBuilder('Vpbxui\Extension\Model\Extension')
									  ->disableOriginalConstructor()
									  ->getMock();
		$serviceManager->setService('Vpbxui\Extension\Model\Extension', $this->mockedExtension);
		 
		$this->mockedAdapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
									->disableOriginalConstructor()
									->getMock();
		$serviceManager->setService('Zend\Db\Adapter\Adapter', $this->mockedAdapter);
		
		$this->mockedRouteTable = $this->getMockBuilder('Vpbxui\Route\Model\RouteTable')
									  ->disableOriginalConstructor()
									  ->getMock();
		$serviceManager->setService('Vpbxui\Route\Model\RouteTable', $this->mockedRouteTable);
		
		
		$this->mockedRegEntryTable = $this->getMockBuilder('Vpbxui\RegEntry\Model\RegEntryTable')
										  ->disableOriginalConstructor()
										  ->getMock();
		$serviceManager->setService('Vpbxui\RegEntry\Model\RegEntryTable', $this->mockedRegEntryTable);
		
		
		$this->mockedNumberMatchTable = $this->getMockBuilder('Vpbxui\NumberMatch\Model\NumberMatchTable')
											->disableOriginalConstructor()
											->getMock();
		$serviceManager->setService('Vpbxui\NumberMatch\Model\NumberMatchTable', $this->mockedNumberMatchTable);
		
		
		$this->mockedTrunkDestinationTable = $this->getMockBuilder('Vpbxui\TrunkDestination\Model\TrunkDestinationTable')
												  ->disableOriginalConstructor()
												  ->getMock();
		$serviceManager->setService('Vpbxui\TrunkDestination\Model\TrunkDestinationTable', $this->mockedTrunkDestinationTable);
		

		$this->mockedCallCentreScheduleTable = $this->getMockBuilder('Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTable')
													->disableOriginalConstructor()
													->getMock();
		$serviceManager->setService('Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTable', $this->mockedCallCentreScheduleTable);	
				
        $this->context = $serviceManager->get('Vpbxui\Context\Model\Context');
		
		$this->controller = $factory->createService($serviceManager);
		
		 
		
		$this->request    = new Request();
		$this->routeMatch = new RouteMatch(array('controller' => 'Restful\Controller\VpbxEnv'));
		$this->event      = new MvcEvent();
		$config = $serviceManager->get('Config');
		$routerConfig = isset($config['router']) ? $config['router'] : array();
		$router = HttpRouter::factory($routerConfig);

		$this->event->setRouter($router);
		$this->event->setRouteMatch($this->routeMatch);
		$this->controller->setEvent($this->event);
		$this->controller->setServiceLocator($serviceManager);
		$this->request->getHeaders()->addHeaderLine('Content-Type','application/json');
		self::$functions = m::mock();
		
		
	}
	public function testCreateActionCanBeAccessed()
	{	
		$this->request->setMethod(Request::METHOD_POST);

		$this->mockedVpbxidProvider->expects($this->atLeastOnce())
		                           ->method('getVpbxId')
		                           ->with()
		                           ->will($this->returnValue(1));
		
		
		
		$vpbxEnv = new VpbxEnv();
		$vpbxEnv->exchangeArray(array(
		    'vpbx_name' => 'виртульная АТС для тестов',
		    'vpbx_description' => 'виртульная АТС для тестов',
		    'vpbx_remotevpbxid'=>1		    
		));
		$vpbxEnvResult = clone $vpbxEnv;
		$vpbxEnvResult->sip_id = 22;
		$vpbxEnvResult->sip_name = 'vpbx_022';
		$vpbxEnvResult->sip_secret = '123456790abc';
 		
		$this->mockedVpbxEnvTable->expects($this->once())
		                         ->method('saveVpbxEnv')
		                         ->with($vpbxEnv)
		                         ->will($this->returnValue($vpbxEnvResult));
        
		$generalSettings = new GeneralSettings();
		
		$generalSettings->vpbxid = 1;
		$this->mockedGeneralSettingsTable->expects($this->once())
		                          ->method('getSettings')
		                          ->with(1)
		                          ->will($this->returnValue($generalSettings));
		
		$mediaStack = array();
        $media = new TempMedia();
        $media->id=1;        
        $media->custname = 'test_worktime_greeting.mp3';
        $media->custdesc = '';
        $media->filesize = 123322;
        $media->contenttype = 'application/mp3';
        $mediaStack['wtgreeting'] = $media;
        
        $media = new TempMedia();
        $media->id=2;
        $media->custname = 'test_weekend_greeting.mp3';
        $media->custdesc = '';
        $media->filesize = 123322;
        $media->contenttype = 'application/mp3';
        $mediaStack['wegreeting'] = $media;
        
        $media = new TempMedia();
        $media->id=3;
        $media->custname = 'test_mohtone.mp3';
        $media->custdesc = '';
        $media->filesize = 123322;
        $media->contenttype = 'application/mp3';
        $mediaStack['musiconhold'] = $media;
        
        
        $media = new TempMedia();
        $media->id=4;
        $media->custname = 'test_ringingbacktone.mp3';
        $media->custdesc = '';
        $media->filesize = 123322;
        $media->contenttype = 'application/mp3';
        $mediaStack['ringingbacktone'] = $media;
        
        
 		$this->mockedWizardSessionContainer['media'] = $mediaStack;
		
 		
        $mediaRepos = new MediaRepos();
        $mediaRepos->custname = 'test_worktime_greeting.mp3';
        $mediaRepos->contenttype = 'application/mp3';
        $mediaRepos->custdesc = '';
        $mediaRepos->mediatype = 'ANYMEDIA';
        $mediaRepos->filesize = 123322;
        $mediaRepos->vpbxid = 1;
 		
 		$this->mockedMediaReposTable->expects($this->at(0))
 		                            ->method('saveMediaRepos')
 		                            ->with($mediaRepos)
 		                            ->will($this->returnValue(1));
 		
 			
 		
  		$mediaRepos = new MediaRepos();
 		$mediaRepos->custname = 'test_weekend_greeting.mp3';
 		$mediaRepos->contenttype = 'application/mp3';
 		$mediaRepos->custdesc = '';
 		$mediaRepos->mediatype = 'ANYMEDIA';
 		$mediaRepos->filesize = 123322;
 		$mediaRepos->vpbxid = 1;
 		
  		  		
 			
 		$this->mockedMediaReposTable->expects($this->at(1))
 		->method('saveMediaRepos')
 		->with($mediaRepos)
 		->will($this->returnValue(2));

 		
 		$mediaRepos = new MediaRepos();
 		$mediaRepos->custname = 'test_mohtone.mp3';
 		$mediaRepos->contenttype = 'application/mp3';
 		$mediaRepos->custdesc = '';
 		$mediaRepos->mediatype = 'ANYMEDIA';
 		$mediaRepos->filesize = 123322;
 		$mediaRepos->vpbxid = 1;
  		  
 		$this->mockedMediaReposTable->expects($this->at(2))
 		->method('saveMediaRepos')
 		->with($mediaRepos)
 		->will($this->returnValue(3));
 		
 		

 		$mediaRepos = new MediaRepos();
 		$mediaRepos->custname = 'test_ringingbacktone.mp3';
 		$mediaRepos->contenttype = 'application/mp3';
 		$mediaRepos->custdesc = '';
 		$mediaRepos->mediatype = 'ANYMEDIA';
 		$mediaRepos->filesize = 123322;
 		$mediaRepos->vpbxid = 1;
 		 		 
 			
 		$this->mockedMediaReposTable->expects($this->at(3))
 		                             ->method('saveMediaRepos')
 		                             ->with($mediaRepos)
 		                             ->will($this->returnValue(4));
 			
 		
 		self::$functions->shouldReceive('rename')->with("/tmp/1", "/var/lib/asterisk/mediarepos/1")->once();
 		self::$functions->shouldReceive('rename')->with("/tmp/2", "/var/lib/asterisk/mediarepos/2")->once();
 		self::$functions->shouldReceive('rename')->with("/tmp/3", "/var/lib/asterisk/mediarepos/3")->once();
 		self::$functions->shouldReceive('rename')->with("/tmp/4", "/var/lib/asterisk/mediarepos/4")->once();
 			
        $generalSettings = new GeneralSettings();
        $generalSettings->vpbxid = 1;
        $generalSettings->greeting = 1;
        $generalSettings->greetingofftime = 2;        
        $generalSettings->ringingtone = 4;
        $generalSettings->mohtone =  3;
        
 		
 		$this->mockedGeneralSettingsTable->expects($this->once())
 		->method('saveSettings')
 		->with($generalSettings)
 		->will($this->returnValue(1));
 		
 		
 		$trunk =  new Trunk();
 		$trunk->name = 'vpbx_022';
 		$trunk->secret = '123456790abc';
 		$trunk->callbackextension = 'vpbx_022';
 		$trunk->context = 'vpbx_dialout';
 		$trunk->host = 'serv-02';
 		
 		
 		$this->mockedTrunkTable->expects($this->once())
 		                        ->method('saveTrunk')
 		                         ->with($trunk)
 		                         ->will($this->returnValue(422));
 		
 		
 		$ivr = new Ivr();
        $ivr->custname = 'основной';
	    $ivr->custdesc = 'основной'; 		
 		
	    $this->mockedIvrTable->expects($this->once())
	                         ->method('saveIvr')
	                         ->with($ivr)
	                         ->will($this->returnValue(1));
	    	
	    $context = clone $this->context;
        $data = array(
	        'custname' => 'основной',
	        'custdesc' => 'основной',
	        'contexttype' => 'IVR',
	        'ivrref'=>1
	    );	    
	    $context->exchangeArray($data);
	    $this->mockedContextTable->expects($this->once())
	         ->method('saveContext')
	         ->with($context)
	         ->will($this->returnValue(1));
	    
	    $trunkAssoc = new TrunkAssoc();
	    $data = array(
	        'trunkref'=>422,
	        'contextref'=>1
	    );
	    $trunkAssoc->exchangeArray($data);
	    $this->mockedTrunkAssocTable->expects($this->once())
	                               ->method('saveTrunkAssoc')
	                               ->with($trunkAssoc)
	                               ->will($this->returnValue(null));
	    
	    
	    $extensionGroup = new ExtensionGroup();
	    $extensionGroup->name = 'обычные';
	    $extensionGroup->custdesc = 'обычные';
	    $extensionGroup->memberofcallcentreque = 'false';
	    $extensionGroup->extensionrecord = 'false';
 	    $this->mockedExtensionGroupTable->expects($this->at(0))
	                                    ->method('saveExtensionGroup')
	                                    ->with($extensionGroup)
	                                    ->will($this->returnValue(1));
	     
	    
	    $extensionGroup = new ExtensionGroup();
	    $extensionGroup->name = 'операторы';
	    $extensionGroup->custdesc = 'операторы';
	    $extensionGroup->memberofcallcentreque = 'true';
	    $extensionGroup->extensionrecord = 'true';
 	    $this->mockedExtensionGroupTable->expects($this->at(1))
	                                    ->method('saveExtensionGroup')
	                                    ->with($extensionGroup)
	                                    ->will($this->returnValue(2));
	     
	    
	    
	    $internalnumbers = array();	    
	    $extension = new Extension();
	    $extension->extension = 301;
	    $extension->custname = 'Иван Петров';
	    $extension->extensiontype = 'regular';
	    $extension->extensiongroup = 1;
	    $internalnumbers[]  = $extension;	     
	    $extension = new Extension();
	    $extension->extension = 302;
	    $extension->custname = 'Петр Сидоров';
	    $extension->extensiontype = 'operator';
	    $extension->extensiongroup = 2;	     
	    $internalnumbers[]  = $extension;
	    $this->mockedWizardSessionContainer->internalnumbers = $internalnumbers;
	
		$did = new Did();
		$did->digits='4997337930';
		$this->mockedWizardSessionContainer->did = $did;

		$numberMatch = new NumberMatch();
		$numberMatch->custname = 'любой номер (catchall)';
	    $this->mockedNumberMatchTable->expects($this->once())
	                                    ->method('saveNumberMatch')
	                                    ->with($numberMatch)
	                                    ->will($this->returnValue(123));
	     $regEntry = new RegEntry();
	     $regEntry->numbermatchref = 123;
	     $regEntry->regexpression = '/[\d]{7,15}/';

	     $this->mockedRegEntryTable->expects($this->once())
	                               ->method('saveRegEntry')
	                               ->with($regEntry)
	                               ->will($this->returnValue(124));
	     
	     $route = new Route();
	     $route->custname = 'ТФОП 4997337930';
	     $route->custdesc = '';
	     $route->isdefault = true;
	     
	     $this->mockedRouteTable->expects($this->once())
	                            ->method('saveRoute')
	                            ->with($route)
	                            ->will($this->returnValue(125));
	    		
	    $trunkDestination = new TrunkDestination();
	    $trunkDestination->numbermatchref = 123;
	    $trunkDestination->routeref = 125;
	    $trunkDestination->trunkref = 422;

	    $this->mockedTrunkDestinationTable->expects($this->once())
	                                       ->method('saveTrunkDestination')
	                                       ->with($trunkDestination)
	                                       ->will($this->returnValue(126));
	     
	    $callCentreSchedule = new CallCentreSchedule();
	    $this->mockedCallCentreScheduleTable->expects($this->once())
	                                        ->method('saveCallCentreSchedule')
	                                        ->with($callCentreSchedule)
	                                        ->will($this->returnValue(null));
	     
	    
		$result   = $this->controller->dispatch($this->request);
		$response = $this->controller->getResponse();
		
		
		$this->assertEquals(Response::STATUS_CODE_201, $response->getStatusCode());

	   $this->assertEquals(true, $this->mockedWizardSessionContainer->completed);
	}
 
	function tearDown()
	{
	    m::close();
	}
}
}