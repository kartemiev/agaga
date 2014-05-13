<?php
namespace PbxAgiTest\Controller\Plugin\RedirectorControllerPlugin;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\Plugin\RedirectorControllerPluginFactory;

class RedirectorControllerPluginTest extends PHPUnit_Framework_TestCase
{
    public function test_can_redirect_when_match()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $factory = new RedirectorControllerPluginFactory();
        $redirectorPlugin = $factory->createService($serviceManager);

        $mockedController =  $this->getMockBuilder('Zend\Mvc\Controller\AbstractActionController')
                                ->disableOriginalConstructor()
                                ->getMock();
        $redirectorPlugin->setController($mockedController);        
         
        $mockedForward =  $this->getMockBuilder('Zend\Mvc\Controller\Plugin\Forward')
                                ->disableOriginalConstructor()
                                ->getMock();

        $mockedController->expects($this->once())
                         ->method('__call')
                         ->with('forward')
                         ->will($this->returnValue($mockedForward));
        
        $mockedForward->expects($this->once())
                        ->method('dispatch')
                        ->with('\PbxAgi\Controller\ShortDialFeature', array('action'=>'index'))
                        ->will($this->returnValue(true));
        
        $redirectorPlugin->dispatch('/dialout/regular/*30');
        
    }
    public function test_can_handle_when_not_match()
    {
    	$serviceManager = Bootstrap::getServiceManager();
    	$factory = new RedirectorControllerPluginFactory();
    	$redirectorPlugin = $factory->createService($serviceManager);
    
    	$mockedController =  $this->getMockBuilder('Zend\Mvc\Controller\AbstractActionController')
    	->disableOriginalConstructor()
    	->getMock();
    	$redirectorPlugin->setController($mockedController);
    	 
    	$mockedForward =  $this->getMockBuilder('Zend\Mvc\Controller\Plugin\Forward')
    	->disableOriginalConstructor()
    	->getMock();
    
    	$mockedController->expects($this->once())
    	->method('__call')
    	->with('forward')
    	->will($this->returnValue($mockedForward));
    
    
    	$redirectorPlugin->dispatch('/invalidroute');
    
    }
    
}