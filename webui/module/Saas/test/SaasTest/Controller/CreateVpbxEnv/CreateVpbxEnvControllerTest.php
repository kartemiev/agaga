<?php
namespace SaasTest\Controller\CreateVpbxEnv;

use \SaasTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;
use Zend\Db\ResultSet\ResultSet;
use Saas\Controller\CreateVpbxEnvControllerFactory;

class ConferenceBookingControllerTest extends \PHPUnit_Framework_TestCase
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
	
 	protected function setUp()
	{
		$serviceManager = Bootstrap::getServiceManager();
		
		$factory = new CreateVpbxEnvControllerFactory();
		
		$this->mockedWizardSessionContainer =  $this->getMockBuilder('Saas\WizardSessionContainer\WizardSessionContainer')
											->disableOriginalConstructor()
										    ->getMock();
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
		
		
		$this->controller = $factory->createService($serviceManager);
		
		 
		
		$this->request    = new Request();
		$this->routeMatch = new RouteMatch(array('controller' => 'Saas\Controller\CreateVpbxEnv'));
		$this->event      = new MvcEvent();
		$config = $serviceManager->get('Config');
		$routerConfig = isset($config['router']) ? $config['router'] : array();
		$router = HttpRouter::factory($routerConfig);

		$this->event->setRouter($router);
		$this->event->setRouteMatch($this->routeMatch);
		$this->controller->setEvent($this->event);
		$this->controller->setServiceLocator($serviceManager);
	}
	public function testIndexActionCanBeAccessed()
	{
		$this->routeMatch->setParam('action', 'index');
	
		$result   = $this->controller->dispatch($this->request);
		$response = $this->controller->getResponse();
	
		$this->assertEquals(200, $response->getStatusCode());
	}
	/*
	public function testAbleToBookRoomForOneDay()
	{		 
		$this->routeMatch->setParam('action', 'index');
		
		$request = $this->request;
		$request->setMethod(Request::METHOD_POST);
		$post = $request->getPost();
		$post->set('confnumber', '1234');
		$post->set('reserveduration', '0');
		$post->set('joinacl', 'ALL');
		$post->set('pin', '1234');
		
		$durationSeconds =  24*60*60;  
		$date = new \DateTime();
		$date->modify("+{$durationSeconds} seconds");
		$datesettoexpiry = $date->format('Y-m-d H:i:s');
		
 		$data = array(
				'confnumber'=>'1234',
 				'pin'=>'1234',
				'joinacl'=>'ALL',			
 				'reserveduration'=>'0'	
				);
		
 		$serviceLocator = $this->controller->getServiceLocator();
 		
		$conference = $serviceLocator->get('Vpbxui\Conference\Model\Conference');

		$form = $serviceLocator->get('Vpbxui\Conference\Form\ConferenceForm');
		$form->setInputFilter($conference->getInputFilter());
		$form->setData($data);
		$formIsValid = $form->isValid();
		$formData = $form->getData();
		$conference->exchangeArray($formData);
		$conference->datesettoexpiry = $datesettoexpiry;
		$conference->isprivate = 1;
 		 
	
 		$this->mockedDateTime->expects($this->once())
 							 ->method('modify')
 						     ->with("+{$durationSeconds} seconds")
 							 ->will($this->returnValue(true));

 		$this->mockedDateTime->expects($this->once())
 							 ->method('format')
 							 ->with('Y-m-d H:i:s')
 							 ->will($this->returnValue($datesettoexpiry));
 			
 		
 		$this->mockedConferenceTable->expects($this->once())
 			 ->method('saveConference')
 			 ->with($conference)
 			 ->will($this->returnValue(true));
 		
 		$result = array(array('confnum'=>1234));
 		$resultSet = new ResultSet();
 		$resultSet->initialize($result);

 		$this->mockedConferenceFreeTable->expects($this->once())
 			 ->method('fetchAll')
 			  ->with(array('confnumber'=>1234),1)
 			  ->will($this->returnValue($resultSet));
 		
		$result   = $this->controller->dispatch($this->request);
		$response = $this->controller->getResponse();
	
		$this->assertEquals(302, $response->getStatusCode());
	}
	*/
}