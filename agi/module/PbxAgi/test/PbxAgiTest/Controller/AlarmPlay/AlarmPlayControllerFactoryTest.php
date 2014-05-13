<?php
namespace PbxAgiTest\Controller\Alarm;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\AlarmPlayControllerFactory;
    
class AlarmPlayControllerFactoryTest extends PHPUnit_Framework_TestCase
{ 
    protected $alarmPlayController;
      public function setUp()
    {     	
        \Logger::shutdown();
        $serviceManager = Bootstrap::getServiceManager();
        $serviceManager->setAllowOverride(true);
        
          
        $alarmPlayControllerFactory = new AlarmPlayControllerFactory();
        
        $mockedClientImpl = $this->getMockBuilder('PbxAgi\Service\ClientImpl\ClientImpl')
                                 ->disableOriginalConstructor()
                                 ->getMock();
        
        
         $serviceManager->setService('ClientImpl', $mockedClientImpl);
        
        $this->alarmPlayController = $alarmPlayControllerFactory->createService($serviceManager);
        
     }
     public function testAlarmPlayControllerFactoryReturnsInstanceOfAlarmPlayController()
     {
 
          $this->assertInstanceOf('PbxAgi\Controller\AlarmPlayController', $this->alarmPlayController, 'AlarmPlayController Factory should have returned instance of AlarmPlayController');
     }
}

