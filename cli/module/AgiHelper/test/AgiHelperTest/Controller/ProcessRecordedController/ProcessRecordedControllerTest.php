<?php
namespace AgiHelperTest\Controller\ProcessRecorded;

use \AgiHelperTest\Bootstrap;
use Zend\Mvc\Router\Console\SimpleRouteStack as ConsoleRouter;
use Zend\Console\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use AgiHelper\Controller\ProcessRecordedControllerFactory;
use AgiHelper\RecordedCall\Model\RecordedCall;

class ProcessRecordedControllerTest extends AbstractControllerTestCase
{
	protected $mockedRecordedCallTable;
	protected $mockedRecordedCallCommands;
	protected $mockedPurgeOldRecordings;

    public function setUp()
    {     	 
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);  
        
         
        $this->mockedRecordedCallTable = $this->getMockBuilder('AgiHelper\RecordedCall\Model\RecordedCallTable')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        
        $serviceManager->setService('AgiHelper\RecordedCall\Model\RecordedCallTable', $this->mockedRecordedCallTable);
        
        $this->mockedRecordedCallCommands =  $this->getMockBuilder('AgiHelper\Service\RecordedCall\RecordedCallCommands')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        
        $serviceManager->setService('AgiHelper\Service\RecordedCall\RecordedCallCommands', $this->mockedRecordedCallCommands);


        $this->mockedPurgeOldRecordings =  $this->getMockBuilder('AgiHelper\Service\RecordedCall\PurgeOldRecordings')
        						 ->disableOriginalConstructor()
        					     ->getMock();
        
        $serviceManager->setService('AgiHelper\Service\RecordedCall\PurgeOldRecordings', $this->mockedPurgeOldRecordings);
        
        
        
        $processRecordedFactory = new ProcessRecordedControllerFactory();
        $this->controller = $processRecordedFactory->createService($serviceManager);
        
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'AgiHelper\Controller\ProcessRecordedController'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = ConsoleRouter::factory($routerConfig);
  
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this->routeMatch->setParam('action', 'Index');
        $this->routeMatch->setParam('filename', '1234567890');
        
        
     }
    
      
     public function test_process_recorded_controller_can_process_recording_properly()
     {

         $mockedRecordedCallCommands = $this->mockedRecordedCallCommands;
         $mockedRecordedCallCommands->expects($this->once())->method('convert')
         										->with('1234567890')
                                                ->will($this->returnValue(null));
         $mockedRecordedCallCommands->expects($this->once())->method('cleanUp')
         									    ->will($this->returnValue(null));

         $mockedRecordedCallCommands->expects($this->once())->method('getDstFileSize')
         										->will($this->returnValue(10241024));
         

         $mockedRecordedCallTable = $this->mockedRecordedCallTable;
         
         $recordedcall = new RecordedCall();
         
         $data = array('cdrref'=>'1234567890',
    		'filesize'=>10241024,
    		'status'=>'EXISTS');
         
         $recordedcall->exchangeArray($data);
         
         $mockedRecordedCallTable->expects($this->once())->method('saveRecordedCall')
         										->with($recordedcall)          
         									    ->will($this->returnValue(null));
          
        $mockedPurgeOldRecordings = $this->mockedPurgeOldRecordings;
        $mockedPurgeOldRecordings->expects($this->once())->method('__invoke')
        						->will($this->returnValue(null));
        
         
      	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
      }
      
    
}