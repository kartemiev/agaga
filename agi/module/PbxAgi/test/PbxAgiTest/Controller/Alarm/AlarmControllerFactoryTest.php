<?php
namespace PbxAgiTest\Controller\Alarm;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\AlarmControllerFactory;
   
class AlarmControllerFactoryTest extends PHPUnit_Framework_TestCase
{ 
    protected $alarmController;
      public function setUp()
    {     	
        \Logger::shutdown();
        $serviceManager = Bootstrap::getServiceManager();
        $serviceManager->setAllowOverride(true);
        
          
        $alarmControllerFactory = new AlarmControllerFactory();
        
        $mockedClientImpl = $this->getMockBuilder('PbxAgi\Service\ClientImpl\ClientImpl')
                                 ->disableOriginalConstructor()
                                   ->getMock();
        
        
         $serviceManager->setService('ClientImpl', $mockedClientImpl);
        
         $mockedAppConfig = $this->getMockBuilder('PbxAgi\Service\AppConfig\AppConfigService')
         ->disableOriginalConstructor()
         ->getMock();
         
         
         $serviceManager->setService('AppConfig', $mockedAppConfig);
         
         
        $this->alarmController = $alarmControllerFactory->createService($serviceManager);
        
     }
     public function testAlarmControllerFactoryReturnsInstanceOfAlarmController()
     {
 
          $this->assertInstanceOf('PbxAgi\Controller\AlarmController', $this->alarmController, 'AlarmController Factory should have returned instance of alarm controller');
     }
}

