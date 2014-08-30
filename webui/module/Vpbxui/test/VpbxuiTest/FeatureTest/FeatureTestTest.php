<?php
namespace VpbxuiTest\FeatureTest;

use \VpbxuiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Vpbxui\Entity\User;
use Vpbxui\FeatureTest\Model\FeatureTest;
 
class FeatureTestTest extends \PHPUnit_Framework_TestCase
{
    protected $featureTestTable;
    protected $zfcAuthService;
    protected function setUp()
	{
		$serviceManager = Bootstrap::getServiceManager();
		
	
		$this->zfcAuthService =  $this->getMockBuilder('\Zend\Authentication\AuthenticationService')
											->disableOriginalConstructor()
										    ->getMock();
		$serviceManager->setService('zfcuser_auth_service', $this->zfcAuthService);
				
        $this->featureTestTable = $serviceManager->get('Vpbxui\FeatureTest\Model\FeatureTestTable');        

        $this->zfcAuthService->expects($this->any())
        ->method('hasIdentity')
        ->with()
        ->will($this->returnValue(true));
        
        $user = new User();
        $user->setVpbxid(1);
         
        $this->zfcAuthService->expects($this->any())
        ->method('getIdentity')
        ->with()
        ->will($this->returnValue($user));
        
	}
	
	public function testVpbxidFeatureIsCanAccessRecordWhereVpbxIdMatches()
	{

	 
	    
	    $featureTest =  $this->featureTestTable->getFeatureTest(1);
	    $this->assertInstanceOf('Vpbxui\FeatureTest\Model\FeatureTest', $featureTest);
	}
	public function testVpbxidFeatureIsCannotAccessRecordWhereVpbxIdNotMatches()
	{

	  
	    $this->setExpectedException('Exception');
	     
	    $featureTest =  $this->featureTestTable->getFeatureTest(2);
  	}
  	public function testVpbxidFeatureCanIncludeVpbxIdWhenInserted()
  	{

  	   
  	    $featureTest = new FeatureTest();
  	    $featureTest->test1 = 2;
  	    $featureTest->test2 = 4;
  	    $featureTest->test3 = 5;
  	    $lastId =  $this->featureTestTable->saveFeatureTest($featureTest);  	    
  	    $this->featureTestTable->deleteFeatureSet($lastId);
  	    
  	}
  	public function testVpbxidFeatureCantUpdateInvalidVpbxId()
  	{

  	     
  	    
  	    $this->setExpectedException('Exception');
  	     
  	    $featureTest = new FeatureTest();
  	    $featureTest->id = 10;
  	    $featureTest->test1 = 2;
  	    $featureTest->test2 = 4;
  	    $featureTest->test3 = 6;
  	    $lastId =  $this->featureTestTable->saveFeatureTest($featureTest);
  	}
  	public function testVpbxidFeatureDeleteInvalidVpbxId()
  	{  	
 
  	    $this->featureTestTable->deleteFeatureSet(16);
  	 }
  	 
}