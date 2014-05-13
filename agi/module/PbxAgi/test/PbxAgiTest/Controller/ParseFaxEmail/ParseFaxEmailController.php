<?php
namespace PbxAgiTest\Controller\ParseFaxEmail;

use \PbxAgiTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\FaxSpool\Model\FaxSpool;
use PbxAgi\FaxUser\Model\FaxUser;
use PAGI\CallSpool\Impl\CallSpoolImpl;
use PbxAgi\Controller\ParseFaxEmailControllerFactory;
use PbxAgi\DialDescriptor\LocalDialDescriptor;
use PAGI\CallSpool\CallFile;      

class ParseFaxEmailControllerTest extends AbstractControllerTestCase
{
   protected $mockedSendEmail;
   protected $mockedFaxUserTable;
   protected $mockedFaxSpoolTable;
   protected $mockedFaxSpoolLogTable;
   protected $mockedReader;
   protected $mockedWriter;
   protected $mockedExecuter;
   protected $appConfig;
   protected $mockedCallSpoolImpl;
   
      public function setUp()
    {
                        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);  

        $mockedSendEmail =  $this->getMockBuilder('PbxAgi\Service\SendEmail\SendEmail')
        						 ->disableOriginalConstructor()
        						 ->getMock();

        $serviceManager->setService('PbxAgi\Service\SendEmail\SendEmail', $mockedSendEmail);
        $this->mockedSendEmail = $mockedSendEmail;        
        
        $mockedFaxUserTable =  $this->getMockBuilder('PbxAgi\FaxUser\Model\FaxUserTable')
        							->disableOriginalConstructor()
        						    ->getMock();
        
        $serviceManager->setService('PbxAgi\FaxUser\Model\FaxUserTable', $mockedFaxUserTable);
        $this->mockedFaxUserTable = $mockedFaxUserTable;
        
        
 
        $mockedFaxSpoolTable =  $this->getMockBuilder('PbxAgi\FaxSpool\Model\FaxSpoolTable')
        							 ->disableOriginalConstructor()
        							 ->getMock();
        
        $serviceManager->setService('PbxAgi\FaxSpool\Model\FaxSpoolTable', $mockedFaxSpoolTable);
        $this->mockedFaxSpoolTable = $mockedFaxSpoolTable;
        
        
        $mockedFaxSpoolLogTable =  $this->getMockBuilder('PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTable')
        							    ->disableOriginalConstructor()
        								->getMock();
        
        $serviceManager->setService('PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTable', $mockedFaxSpoolLogTable);
        $this->mockedFaxSpoolLogTable = $mockedFaxSpoolLogTable;
        
        
        $mockedReader =  $this->getMockBuilder('PbxAgi\Service\Reader\Reader')
        						   ->disableOriginalConstructor()
        						   ->getMock();
        
        $serviceManager->setService('PbxAgi\Service\Reader\Reader', $mockedReader);
        $this->mockedReader = $mockedReader;
                
        $mockedWriter =  $this->getMockBuilder('PbxAgi\Service\Writer\Writer')
        					  ->disableOriginalConstructor()
        					  ->getMock();
        
        $serviceManager->setService('PbxAgi\Service\Writer\Writer', $mockedWriter);
        $this->mockedWriter = $mockedWriter;
        
        
        
        $mockedExecuter =  $this->getMockBuilder('PbxAgi\Service\Executer\Executer')
        						->disableOriginalConstructor()
        						->getMock();
        
        $serviceManager->setService('PbxAgi\Service\Executer\Executer', $mockedExecuter);
        $this->mockedExecuter = $mockedExecuter;
                
        $mockedCallSpoolImpl =  $this->getMockBuilder('PbxAgi\Service\CallSpool\CallSpoolImpl')
        							 ->disableOriginalConstructor()
        							 ->getMock();
        
        $serviceManager->setService('PbxAgi\Service\CallSpool\CallSpoolImpl', $mockedCallSpoolImpl);
        $this->mockedCallSpoolImpl = $mockedCallSpoolImpl;
                
        
        $parseFaxEmailControllerFactory = new ParseFaxEmailControllerFactory();
        $this->controller = $parseFaxEmailControllerFactory->createService($serviceManager);
        
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'PbxAgi\Controller\ParseFaxEmail'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
  
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this->routeMatch->setParam('action', 'Index');
        
     }
    
      
     public function test_parsefaxemail_controller_can_spool_successful_emailfax_faximile()
     {     
     	/*
     	$faxSpool = new FaxSpool();
     	$this->mockedFaxSpoolTable->expects($this->once())
     	->method('saveFax')
     	->with($faxSpool)
     	->will($this->returnValue(1));
   
     	$this->mockedReader->expects($this->once())
     		 ->method('getReadedValue')
      		 ->will($this->returnValue(require 'SampleFaximile.php'));
     	 
     	 
      	
     	$faxUser = new FaxUser();
     	$faxUser->email = 'kartemiev@gmail.com';
     	$this->mockedFaxUserTable->expects($this->once())
     		 ->method('getFaxUserByEmail')
     		 ->with('kartemiev@gmail.com')
     		 ->will($this->returnValue($faxUser));
     		      	
     	
     	$this->mockedWriter->expects($this->once())
     		 ->method('writeStream')
     		 ->with('/ofofjfj')
     		 ->will($this->returnValue(true));

     	$appConfig = $this->getAppConfig();
     	     	
    	$faxSpoolPath = $appConfig->getFaxSpoolPath().'/1.tiff';
        $gsBin = $appConfig->getGhostscriptBinaryPath();
     	
     	$this->mockedExecuter->expects($this->once())
     		 ->method('exec')
     		 ->with("{$gsBin} -q -sDEVICE=tiffg3 -r204x196 -dBATCH -dPDFFitPage -dNOPAUSE -sOutputFile=\"{$faxSpoolPath}\" \"/tmp/dkkdmk\"")
     		 ->will($this->returnValue(true));

      	$dialDescriptor = new LocalDialDescriptor('89251999108', $appConfig->getFaxdialerContextName());
     	$callFile = new CallFile($dialDescriptor);
     	
     	$callFile->setExtension('89251999108');
     	$callFile->setVariable('FILENAME', $appConfig->getFaxSpoolPath().'/1.tiff');
     	$callFile->setVariable('SPOOLID', '1');
     	$callFile->setPriority('1');
     	$callFile->setMaxRetries($appConfig->getFaxSendMaxTries());
     	$callFile->setWaitTime($appConfig->getFaxSendWaitTime());

     	
     	$options = array(
     					'tmpDir' => $appConfig->getTmpDir(),
     					'spoolDir' => $appConfig->getAsteriskCallfileSpoolPath()
     			);
     	$callSpoolImplInstance = CallSpoolImpl::getInstance($options);

     	$this->mockedCallSpoolImpl->expects($this->once())
     							  ->method('getInstance')
     							  ->with($options)
     				   			  ->will($this->returnValue($callSpoolImplInstance));

     	$this->mockedCallSpoolImpl->expects($this->once())
     							  ->method('spool')
     							  ->with($callFile)
     							  ->will($this->returnValue(true));
     	
     	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
     	*/
     }
    protected function getAppConfig()
    {
        if (!isset($this->appConfig))
        {
            $this->appConfig = $this->controller->getServiceLocator()->get('AppConfig');
        }
        return $this->appConfig;
    }
    
}