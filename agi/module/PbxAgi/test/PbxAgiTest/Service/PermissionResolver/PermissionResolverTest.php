<?php
namespace PbxAgiTest\Service\PermissionResolver;

use \PbxAgiTest\Bootstrap;
use PbxAgi\Service\PermissionResolver\PermissionResolverFactory;
use PHPUnit_Framework_TestCase;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\ExtensionGroup\Model\ExtensionGroup;
use PbxAgi\ExtensionDefaults\Model\ExtensionDefaults;
use PbxAgi\Service\PermissionResolver\Result;

class PermissionResolverTest extends PHPUnit_Framework_TestCase
{
	protected $permissionResolver;
	protected $mockedExtensionTable;
	protected $mockedExtensionGroupTable;
	protected $mockedExtensionDefaultsTable;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new PermissionResolverFactory();
                
 
        $mockedExtensionTable = $this->getMockBuilder('PbxAgi\Extension\Model\ExtensionTable')
        							 ->disableOriginalConstructor()
       								 ->getMock();        
        $serviceManager->setService('ExtensionTable',$mockedExtensionTable);

        $this->mockedExtensionTable = $mockedExtensionTable;
        
        $mockedExtensionGroupTable =  $this->getMockBuilder('PbxAgi\ExtensionGroup\Model\ExtensionGroupTable')
        ->disableOriginalConstructor()
        ->getMock();      
        $serviceManager->setService('PbxAgi\ExtensionGroup\Model\ExtensionGroupTable', $mockedExtensionGroupTable);
        
        $this->mockedExtensionGroupTable = $mockedExtensionGroupTable;
        
        $mockedExtensionDefaultsTable =  $this->getMockBuilder('PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTable')
        ->disableOriginalConstructor()
        ->getMock();        
         $serviceManager->setService('PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTable', $mockedExtensionDefaultsTable);
        
        $this->mockedExtensionDefaultsTable = $mockedExtensionDefaultsTable;
         
        $this->permissionResolver = $factory->createService($serviceManager);
        
               	      	       	
    }
    public function testCanResolveTransferPermissions()
    {
        $extension = new Extension();
        
        $extension->id = 140;
        $extension->extensiongroup = 1;
        $extension->transfer = 'undefined';
        
        $mockedExtensionTable = $this->mockedExtensionTable;
        $mockedExtensionTable->expects($this->once())
        ->method('getExtensionById')
        ->with(140)
        ->will($this->returnValue($extension));
         
        $extensiongroup = new ExtensionGroup();
        $extensiongroup->id = 1;
        $extensiongroup->vpbxid = 1;
        $extensiongroup->transfer = 'undefined';
        
        $mockedExtensionGroupTable = $this->mockedExtensionGroupTable;
        $mockedExtensionGroupTable->expects($this->once())
        ->method('getExtensionGroup')
        ->with('1')
        ->will($this->returnValue($extensiongroup));
        
        $extensiondefaults = new ExtensionDefaults();
        $extensiondefaults->vpbxid = 1;
        $extensiondefaults->transfer = 'allowed';
         
        $mockedExtensionDefaultsTable = $this->mockedExtensionDefaultsTable;
        
        $mockedExtensionDefaultsTable->expects($this->once())
        ->method('getExtensionDefaults')
        ->with('1')
        ->will($this->returnValue($extensiondefaults));
        
        
    	$permissionResolver = $this->permissionResolver;
    	$extension = new Extension();
    	$extension->id = 140;
    	$permissionResolver->resolv('transfer', $extension);
    	$result = $permissionResolver->getResult();
    	$testResult = new Result();
    	$testResult->value = 'allowed';
    	$this->assertEquals($result, $testResult);    	
    }
    public function testCanResolveExtensionRecordPermissions()
    {
    	$extension = new Extension();
    
    	$extension->id = 140;
    	$extension->extensiongroup = 1;
    	$extension->extensionrecord = 'active';
    
    	$mockedExtensionTable = $this->mockedExtensionTable;
    	$mockedExtensionTable->expects($this->once())
    	->method('getExtensionById')
    	->with(140)
    	->will($this->returnValue($extension));
    	 
    	$extensiongroup = new ExtensionGroup();
    	$extensiongroup->id = 1;
    	$extensiongroup->vpbxid = 1;
    	$extensiongroup->extensionrecord = 'undefined';
    
    	$mockedExtensionGroupTable = $this->mockedExtensionGroupTable;
    	$mockedExtensionGroupTable->expects($this->any())
    	->method('getExtensionGroup')
    	->with('1')
    	->will($this->returnValue($extensiongroup));
    
    	$extensiondefaults = new ExtensionDefaults();
    	$extensiondefaults->vpbxid = 1;
    	$extensiondefaults->extensionrecord = 'active';
    	 
    	$mockedExtensionDefaultsTable = $this->mockedExtensionDefaultsTable;
    
    	$mockedExtensionDefaultsTable->expects($this->any())
    	->method('getExtensionDefaults')
    	->with('1')
    	->will($this->returnValue($extensiondefaults));
    
    
    	$permissionResolver = $this->permissionResolver;
    	$extension = new Extension();
    	$extension->id = 140;
    	$permissionResolver->resolv('extensionrecord', $extension);
    	$result = $permissionResolver->getResult();
    	$testResult = new Result();
    	$testResult->value = 'active';
    	$testResult->id=1;
    	$this->assertEquals($result, $testResult);
    }
    
}