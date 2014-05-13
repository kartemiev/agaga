<?php
namespace PbxAgiTest\Service\ShortDialMenu;
use \PbxAgiTest\Bootstrap;
use PbxAgi\Service\ShortDialMenu\NodeControllerFactory;
use PAGI\Client\Impl\MockedClientImpl;

class NodeControllerFactoryTest
{
    protected $nodeController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
        $this->mockedClientImpl = new MockedClientImpl(array());         
        $serviceManager->setService('ClientImpl', $this->mockedClientImpl);   
         
        $factory = new NodeControllerFactory();
        $this->nodeController = $factory->createService($serviceManager);        
    }
    public function test_factory_returns_instanceof_nodecontroller()
    {
        $this->assertEquals(null, $this->nodeController);        
    }
}
