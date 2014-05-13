<?php
namespace VpbxuiTest\Controller\ConferenceBooking;

use \VpbxuiTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Application\Controller\IndexController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;
use Vpbxui\Controller\ConferenceBookingControllerFactory;
use Vpbxui\Conference\Model\Conference;
use Vpbxui\Conference\Form\ConferenceForm;
use Zend\Db\ResultSet\ResultSet;

class ConferenceBookingControllerTest extends \PHPUnit_Framework_TestCase
{
	protected $controller;
	protected $request;
	protected $response;
	protected $routeMatch;
	protected $event;
	protected $mockedConferenceTable;
	protected $mockedConferenceFreeTable;
	protected $mockedDateTime;
 	protected function setUp()
	{
		$serviceManager = Bootstrap::getServiceManager();
		
		$factory = new ConferenceBookingControllerFactory();
		
		$this->mockedConferenceTable =  $this->getMockBuilder('Vpbxui\Conference\Model\ConferenceTable')
											->disableOriginalConstructor()
										    ->getMock();
		$serviceManager->setService('Vpbxui\Conference\Model\ConferenceTable', $this->mockedConferenceTable);

		$this->mockedConferenceFreeTable =  $this->getMockBuilder('Vpbxui\ConferenceFree\Model\ConferenceFreeTable')
												 ->disableOriginalConstructor()
												 ->getMock();
		$serviceManager->setService('Vpbxui\ConferenceFree\Model\ConferenceFreeTable', $this->mockedConferenceFreeTable);
		

 		 
		
 				
		
		$this->mockedDateTime =  $this->getMockBuilder('\DateTime')
 												 ->getMock();
		$serviceManager->setService('Vpbxui\DateTime', $this->mockedDateTime);
		
		
		$this->controller = $factory->createService($serviceManager);
		
		 
		
		$this->request    = new Request();
		$this->routeMatch = new RouteMatch(array('controller' => 'VpbxUi\Controller\ConferenceBooking'));
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
		
		$durationSeconds =  24*60*60; /* one day - 24 hours */
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
		$conference->isprotected = 1;
 		 
	
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
}