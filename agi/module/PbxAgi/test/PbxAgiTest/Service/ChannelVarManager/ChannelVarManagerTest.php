<?php
namespace PbxAgiTest\Service\ChannelVarManager;

use \PbxAgiTest\Bootstrap;
use PAGI\Client\Impl\MockedClientImpl;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\ChannelVarManager\ChannelVarManager;
use PbxAgi\Entity\CallEntity;
use PbxAgi\Entity\CallOwnerEntity;
use PbxAgi\Entity\CallOriginatorEntity;
use PbxAgi\Entity\CallDestinatorEntity;
use PbxAgi\ChannelDescriptor\ChannelLocalDescriptor;
use PbxAgi\Service\ClientImpl\Peer;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\CallDestination\Model\CallDestination;

class ChannelVarManagerTest extends PHPUnit_Framework_TestCase
{
    public $mockedAgi;
    public $varManager;
    public $mockedPeerTable;
    public $call;
     public function setUp()
    {     	
        \Logger::shutdown();
        $serviceManager = Bootstrap::getServiceManager();
        $serviceManager->setAllowOverride(true);
        
        $mockedAgi = new MockedClientImpl(array());       
        $this->mockedAgi = $mockedAgi;
        

        $mockedPeerTable =  $this->getMockBuilder('PbxAgi\Peer\Model\PeerTable')
                                                         ->disableOriginalConstructor()
                                                         ->getMock();
        
        
         
        $this->mockedPeerTable = $mockedPeerTable;                       
        $serviceManager->setService('PeerTable', $mockedPeerTable);

        $mockedCallEntity =  $this->getMockBuilder('PbxAgi\Entity\CallEntity')
                                  ->disableOriginalConstructor()
                                  ->getMock();
        
        $mockedCallEntity->expects($this->any())
                         ->method('getPeerTable')
                         ->with()
                         ->will($this->returnValue($mockedPeerTable));
        
        

        $serviceManager->setService('CallEntity', $mockedCallEntity);


        $mockedCallOwnerEntity =  $this->getMockBuilder('PbxAgi\Entity\CallOwnerEntity')
                                  ->disableOriginalConstructor()
                                  ->getMock();

        $mockedCallOriginatorEntity =  $this->getMockBuilder('PbxAgi\Entity\CallOriginatorEntity')
                                            ->disableOriginalConstructor()
                                            ->getMock();

        $mockedCallDestinatorEntity =  $this->getMockBuilder('PbxAgi\Entity\CallDestinatorEntity')
                                            ->disableOriginalConstructor()
                                            ->getMock();
        

        $mockedCallEntity->expects($this->any())
                         ->method('getCallOwner')
                         ->with()
                         ->will($this->returnValue($mockedCallOwnerEntity));
        

        $mockedCallEntity->expects($this->any())
                         ->method('getCallOriginator')
                         ->with()
                         ->will($this->returnValue($mockedCallOriginatorEntity));
        

        $mockedCallEntity->expects($this->any())
                        ->method('getCallDestinator')
                        ->with()
                        ->will($this->returnValue($mockedCallDestinatorEntity));

        
        $mockedCallOriginatorEntity->expects($this->any())
                         ->method('getId')
                         ->with()
                         ->will($this->returnValue('10'));
        
        $mockedCallOwnerEntity->expects($this->any())
                        ->method('getId')
                        ->with()
                        ->will($this->returnValue('10'));
        
        $mockedCallDestinatorEntity->expects($this->any())
                        ->method('getId')
                        ->with()
                        ->will($this->returnValue('10'));
        
               
        $serviceManager->setService('CallEntity', $mockedCallEntity);
        
        $this->call = $mockedCallEntity;
        
        $varManager = new ChannelVarManager($mockedAgi, $mockedCallEntity);   
        $this->varManager = $varManager;      
            
        $varManager->setServiceLocator($serviceManager);
     }
     public function testGetExtenReturnsCorrectResult()
     {
        $mockedAgi = $this->mockedAgi;
    	$mockedAgi
    	       ->assert('getVariable',array('EXTEN'))    	
    	       ->onGetVariable(true,'100');
    	$this->assertSame('100', $this->varManager->getExten(),'extension returned should be the same');
      }
      public function testGetChannelDataReturnsCorrectResult()
      {
      	$mockedAgi = $this->mockedAgi;
      	$mockedAgi->assert('getVariable',array('CHANNEL'))
      	          ->onGetVariable(true,'Local/100@context-123445;12345');     
      	$result = $this->varManager->getChannelData('CHANNEL');
     	$this->assertInstanceOf('PbxAgi\ChannelDescriptor\ChannelLocalDescriptor', $result,'channel data variable should return correct result');
      }
      public function testGetPeerResturnsPeerDataWhenOriginalChannelIsRegularChannel()
      {
          $mockedAgi = $this->mockedAgi;
          $mockedAgi->assert('getVariable',array('ORIGINATINGCHANNEL'))
                    ->onGetVariable(true,'SIP/100-123445');
          
          $result = $this->varManager->getPeer();          
          $peer = new Peer('SIP', '100');
          $this->assertTrue($peer==$result,'channel data variable should return correct result');
      }
      public function testGetPeerResturnsPeerDataWhenOriginalChannelIsLocalChannel()
      {
      	$mockedAgi = $this->mockedAgi;
      	$mockedAgi->assert('getVariable',array('ORIGINATINGCHANNEL'))
      	          ->onGetVariable(true,'Local/100@context-123445;12345');
      	
      	$extension = new Extension();
      	$data = array('name'=>'100');
        $extension->exchangeArray($data);      	
      
        $this->mockedPeerTable->expects($this->once())
    	                 ->method('getPeerByExtenNum')
    	                 ->with('100')
    	                 ->will($this->returnValue($extension));     
         	
      	$result = $this->varManager->getPeer();
      	$peer = new Peer('Local', '100');
      	$this->assertTrue($peer==$result,'channel data variable should return correct result');
      }
      
      public function testGetPeerReturnsPeerDataWithPeerNameIsNullWhenOriginalChannelIsLocalChannelAndPeerNotFound()
      {
      	$mockedAgi = $this->mockedAgi;
      	$mockedAgi->assert('getVariable',array('ORIGINATINGCHANNEL'))
      	->onGetVariable(true,'Local/100@context-123445;12345');
      	 
      
      	$this->mockedPeerTable->expects($this->once())
      	->method('getPeerByExtenNum')
      	->with('100')
      	->will($this->returnValue(null));
      
      	$result = $this->varManager->getPeer();
      	$this->assertNull($result,'channel data variable should return null when peer not found');
      }
      public function testSetupOutgoinCallExecutesCorrectlyWhenVariablesPresent()
      {
      	$mockedAgi = $this->mockedAgi;
      	$mockedAgi->assert('getVariable',array('ORIGINATINGCHANNEL'))      	
      	          ->assert('getVariable',array('ORIGINATOR_PEERID'))
      	          ->assert('getVariable',array('OWNER_PEERID'))
      	          ->onGetVariable(true,'SIP/100-123445')      	           
      	          ->onGetVariable(true,'10')
      	          ->onGetVariable(true,'10');
      	
        $this->varManager->setupOutgoingCall($this->call);
       }
       public function testSetupOutgoinCallExecutesCorrectlyWhenVariablesAbsent()
       {
       	$mockedAgi = $this->mockedAgi;
       	$mockedAgi->assert('getVariable',array('ORIGINATINGCHANNEL'))
       	          ->assert('getVariable',array('BLINDTRANSFER'))
       	          ->assert('getVariable',array('CHANNEL'))       	                 	          
       	          ->assert('setVariable',array('__ORIGINATINGCHANNEL','SIP/100-123445'))
       	          ->assert('getVariable',array('ORIGINATOR_PEERID'))       	          
       	          ->onGetVariable(false,null)       	          
        	          ->onGetVariable(false,null)
        	          ->onGetVariable(true,'SIP/100-123445')        	                  	           
        	          ->onGetVariable(false,null)
        	          ->onGetVariable(false,null)
        	           
        	          ;       	          
       	 
       	$this->varManager->setupOutgoingCall($this->call);
       
       }
       public function testCallDestinatorCanBeSetFromChannelVariable()
       {
       	$mockedAgi = $this->mockedAgi;
       	$mockedAgi->assert('getVariable',array('DESTINATOR_PEERID'))
        	          ->onGetVariable(false)
         
       	;
       	 
       	$this->varManager->setCallDestinator();
       	 
       }
       
       public function testGetCallerTransferPermissionReturnsCallerTransferPermissionFromChannelVariable()
       {
       	$mockedAgi = $this->mockedAgi;
       	$mockedAgi->assert('getVariable',array('CALLERTRANSFERPERMISSION'))
       	->onGetVariable(false)
       	 
       	;
       	 
       	$this->assertFalse($this->varManager->getCallerTransferPermission(),'getCallerTransferPermission should return false when respective channel variable is not set');
       	 
       }
       
       public function testGetCalleeTransferPermissionReturnsCalleeTransferPermissionFromChannelVariable()
       {
       	$mockedAgi = $this->mockedAgi;
       	$mockedAgi->assert('getVariable',array('CALLEETRANSFERPERMISSION'))
       	->onGetVariable(false)
       	 
       	;
       	 
       	$this->assertFalse($this->varManager->getCalleeTransferPermission(),'getCalleeTransferPermission should return false when respective channel variable is not set');
       	 
       }
       
       public function testIsRecordingForbiddenReturnsRecodingForbiddenStatusFromChannelVariable()
       {
       	$mockedAgi = $this->mockedAgi;
       	$mockedAgi->assert('getVariable',array('RECORDINGFORBIDDEN'))
       	->onGetVariable(false)
       	 
       	;
       	 
       	$this->assertFalse($this->varManager->isRecordingForbidden(),'isRecordingForbidden should return false when respective channel variable is not set');
       	 
       }
        
     
        
        
}

