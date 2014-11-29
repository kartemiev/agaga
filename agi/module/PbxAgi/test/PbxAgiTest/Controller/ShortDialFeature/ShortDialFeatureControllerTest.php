<?php
namespace PbxAgiTest\Controller\ShortDialFeature;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use PbxAgi\Controller\ShortDialFeatureControllerFactory;
use PAGI\Logger\Asterisk\Impl\AsteriskLoggerImpl;
use PbxAgi\Entity\CallEntity;
use PbxAgi\Entity\CallOwnerEntity;
use PbxAgi\Entity\CallOriginatorEntity;
use PbxAgi\Entity\CallDestinatorEntity;
      
class ShortDialFeatureControllerTest extends AbstractControllerTestCase
{
   private $mockedClientImpl;
   private $mockedCreateMainMenu;
   private $mockedCursorContainterInitializer;
   private $mockedCursorContainer;
   private $mockedNodeController;
   private $mockedPrepareCallControllerPlugin;
   private $serviceLocator;
      public function setUp()
    {
        \Logger::shutdown();
        
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
        
        $this->serviceLocator = $serviceManager;
        $this->mockedClientImpl = new MockedClientImpl(array());         
        $serviceManager->setService('ClientImpl', $this->mockedClientImpl);   
        
        $mockedCreateMainMenu = $this->getMockBuilder('PbxAgi\Service\ShortDialMenu\CreateMainMenu')
                                     ->disableOriginalConstructor()
                                     ->getMock();
        $this->mockedCreateMainMenu = $mockedCreateMainMenu;
        
        $serviceManager->setService('PbxAgi\Service\ShortDialMenu\CreateMainMenu', $mockedCreateMainMenu);
        

        $mockedCursorContainerInitializer = $this->getMockBuilder('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainerInitializer')
                                                 ->disableOriginalConstructor()
                                                 ->getMock();
        $this->mockedCursorContainterInitializer = $mockedCursorContainerInitializer;
        
        $serviceManager->setService('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainerInitializer', $mockedCursorContainerInitializer);
        
        
        
        $mockedCursorContainer = $this->getMockBuilder('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer')
                                      ->disableOriginalConstructor()
                                      ->getMock();
        
        $this->mockedCursorContainer = $mockedCursorContainer;
        

        $serviceManager->setService('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer', $mockedCursorContainer);
        
        

        $mockedNodeController = $this->getMockBuilder('PAGI\Node\NodeController')
                                     ->disableOriginalConstructor()
                                     ->getMock();
        
        $this->mockedNodeController = $mockedNodeController;
        
        
        $factory = new ShortDialFeatureControllerFactory();
        $this->controller = $factory->createService($serviceManager);
        
         
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'PbxAgi\Controller\ShortDialFeatureController'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

       
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this -> controller->getPluginManager()->setServiceLocator($serviceManager);
        
        $mockedPrepareCallControllerPlugin = $this->getMockBuilder( 'PbxAgi\Controller\Plugin\PrepareCallControllerPlugin')
                                                  ->disableOriginalConstructor()
                                                  ->getMock();
        
        
        $this -> controller->getPluginManager()
                            ->setService('PrepareCallControllerPlugin', $mockedPrepareCallControllerPlugin);
        
        $this->mockedPrepareCallControllerPlugin = $mockedPrepareCallControllerPlugin;
        

        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'PbxAgi\Controller\ShortDialFeature'));
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
     
     public function testShortDialFeatureControllerSuccessfullyJumpsToMainMenu()
     {
         
        
         $call = new CallEntity(new CallOwnerEntity(), new CallOriginatorEntity(), new CallDestinatorEntity());
         $this->mockedPrepareCallControllerPlugin->expects($this->once())
                                                 ->method('initCall')
                                                 ->with()
                                                 ->will($this->returnValue($call));
         
         $this->mockedCreateMainMenu->expects($this->once())
                                    ->method('getNodeController')
                                    ->with()
                                    ->will($this->returnValue($this->mockedNodeController));

         $this->mockedCursorContainterInitializer->expects($this->once())
                                                 ->method('initialize')
                                                 ->with($this->mockedCursorContainer,$this->serviceLocator)
                                                 ->will($this->returnValue($this->mockedNodeController));
          

         $this->mockedCreateMainMenu->expects($this->once())
                                    ->method('__invoke')
                                    ->with()
                                    ->will($this->returnValue(null));

         $mockedAgi = $this->mockedClientImpl;
         $mockedAgi->assert('answer')
                     ->onAnswer(true);

         $this->mockedNodeController->expects($this->once())
                                    ->method('jumpTo')
                                    ->with('mainMenu')
                                    ->will($this->returnValue(null));

        
         
         
         $result   = $this->controller->dispatch($this->request);
         $response = $this->controller->getResponse();
         
     
     } 
     
 }
