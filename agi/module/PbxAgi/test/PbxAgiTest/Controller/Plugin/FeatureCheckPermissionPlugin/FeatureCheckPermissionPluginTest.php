<?php
namespace PbxAgiTest\Controller\Plugin\FeatureCheckPermissionPlugin;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\Plugin\FeatureCheckPermissionPluginFactory;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\Service\PermissionResolver\Result;

class FeatureCheckPermissionPlugin extends PHPUnit_Framework_TestCase
{
	protected $featureCheckPermissionPlugin;
    protected $mockedPermissionResolver;
    protected $mockedCallEntity;
    
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
        
        $mockedPermissionResolver = $this->getMockBuilder('PbxAgi\Service\PermissionResolver\PermissionResolver')
                                         ->disableOriginalConstructor()
                                         ->getMock();

        $this->mockedPermissionResolver = $mockedPermissionResolver; 
                
         
        $serviceManager->setService('PbxAgi\Service\PermissionResolver\PermissionResolver', $mockedPermissionResolver);
        
        $mockedCallEntity = $this->getMockBuilder('PbxAgi\Entity\CallEntity')
                                 ->disableOriginalConstructor()
                                 ->getMock();
        
        $serviceManager->setService('CallEntity', $mockedCallEntity);
        
         
        $this->mockedCallEntity = $mockedCallEntity;
        
        $factory = new FeatureCheckPermissionPluginFactory();
                
        $this->featureCheckPermissionPlugin = $factory->createService($serviceManager);        
        
    }
    public function testFeatureCheckPermissionPluginCanResolvePermissionsCorrectly()
    {
    	$featureCheckPermissionPlugin = $this->featureCheckPermissionPlugin;    
    	
    	$extension = new Extension();
    	$data = array(
    		'extension'=>'100'
    	);
        $extension->exchangeArray($data);
        
        $result = new Result();
        $result->value = 'allowed';
        
        $mockedPermissionResolver = $this->mockedPermissionResolver;
        $mockedPermissionResolver->expects($this->once())
                                 ->method('resolv')
                                 ->with('outgoingcall',$extension)
                                 ->will($this->returnValue($result));
        
        $mockedCallEntity = $this->mockedCallEntity;
        $mockedCallEntity->expects($this->once())
                         ->method('getCallOwner')
                         ->with()
                         ->will($this->returnValue($extension));

       
    
        $this->assertSame(true, $this->featureCheckPermissionPlugin->__invoke('outgoingcall', array('allowed')));
    }
}