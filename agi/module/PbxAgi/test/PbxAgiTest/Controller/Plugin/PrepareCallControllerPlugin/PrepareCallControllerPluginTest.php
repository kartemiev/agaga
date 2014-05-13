<?php
namespace PbxAgiTest\Controller\Plugin\PrepareCallControllerPlugin;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\Plugin\RecordCallControllerPluginFactory;
use PAGI\Client\Impl\MockedClientImpl;
use PbxAgi\Controller\Plugin\PrepareCallControllerPluginFactory;
use PbxAgi\Service\ClientImpl\Peer;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\Entity\CallOwnerEntity;
use PbxAgi\Entity\CallOriginatorEntity;

class PrepareCallControllerPluginTest extends PHPUnit_Framework_TestCase
{
	protected $prepareCallControllerPlugin;
	protected $mockedAgi;
	protected $mockedCall;
	protected $mockedPeerTable;
	protected $mockedVarManager;
	public function setUp()
	{
		$serviceManager = Bootstrap::getServiceManager();
		$serviceManager->setAllowOverride(true);
		 
		$this->mockedAgi = new MockedClientImpl(array());
		$serviceManager->setService('ClientImpl', $this->mockedAgi);


		$mockedCall = $this->getMockBuilder('PbxAgi\Entity\CallEntity')
		->disableOriginalConstructor()
		->getMock();
		
		$serviceManager->setService('CallEntity', $mockedCall);
		$this->mockedCall = $mockedCall;
		
		$mockedPeerTable = $this->getMockBuilder('PbxAgi\Peer\Model\PeerTable')
		                        ->disableOriginalConstructor()
		                        ->getMock();
		
		$serviceManager->setService('PbxAgi\Peer\Model\PeerTable', $mockedPeerTable);
		$this->mockedPeerTable = $mockedPeerTable;
		
		$mockedVarmanager = $this->getMockBuilder('PbxAgi\Service\ChannelVarManager\ChannelVarManager')
		                         ->disableOriginalConstructor()
		                         ->getMock();
		
		$serviceManager->setService('ChannelVarManager', $mockedVarmanager);
		$this->mockedVarManager = $mockedVarmanager;
		
		
		$factory = new PrepareCallControllerPluginFactory($serviceManager);
		$this->prepareCallControllerPlugin = $factory->createService($serviceManager);

	}
	public function testInitCallProcessCorrectly()
	{
	    $this->mockedVarManager->expects($this->once())
	                    ->method('setupOutgoingCall')
	                    ->with($this->mockedCall)
	                    ->will($this->returnValue(null));
	    $this->mockedCall->expects($this->once())
	                    ->method('getPeerTable')
	                    ->with()
	                    ->will($this->returnValue($this->mockedPeerTable));
	   

	    $peer = new Peer('SIP','10000');
	    
	    $this->mockedVarManager->expects($this->once())
	                           ->method('getPeer')
	                           ->with()
	                           ->will($this->returnValue($peer));
	    $extension = new Extension();
	    $this->mockedPeerTable->expects($this->once())
	                           ->method('getPeer')
	                           ->with()
	                           ->will($this->returnValue($extension));


	    $this->mockedVarManager->expects($this->once())
	                           ->method('getExten')
	                           ->with()
	                           ->will($this->returnValue('100'));
	     
	    
	    $this->mockedCall->expects($this->once())
	                           ->method('setExten')
	                           ->with('100')
	                           ->will($this->returnValue(null));

	    
	    $this->mockedVarManager->expects($this->once())
	                           ->method('isTransfered')
	                           ->with()
	                           ->will($this->returnValue(true));
	    
	     
	    $this->mockedCall->expects($this->once())
	                           ->method('setTransfered')
	                           ->with(true)
	                           ->will($this->returnValue(null));

	    $callOwner = new CallOwnerEntity();
	    $callOriginator = new CallOriginatorEntity();

	    $mockedCallOriginator = $this->getMockBuilder('PbxAgi\Entity\CallOriginatorEntity')
	                                 ->disableOriginalConstructor()
	                                 ->getMock();

	    $data = array(
	    		'id' => null,
	    		'extension' => null,
	    		'extensiongroup' => null,
	    		'extensiontype' => null,
	    		'name' => null,
	    		'outgoingcallspermission' => null,
	    		'transfer' => null,
	    		'statuschange' => null,
	    		'incoming' => null,
	    		'hold' => null,
	    		'forwarding' => null,
	    		'memberofcallcentreque' => null,
	    		'mailbox' => null,
	    		'callsequence' => null,
	    		'number_status' => null,
	    		'extensionrecord' => null,
	    		'peertype' => null,
	    		'diversion_unconditional_status' => null,
	    		'diversion_unconditional_number' => null,
	    		'diversion_unavail_status' => null,
	    		'diversion_unavail_number' => null,
	    		'diversion_busy_status' => null,
	    		'diversion_busy_number' => null,
	    		'diversion_noanswer_status' => null,
	    		'diversion_noanswer_number' => null,
	    		'diversion_unconditional_landingtype' => null,
	    		'diversion_busy_landingtype' => null,
	    		'diversion_noanswer_landingtype' => null,
	    		'diversion_unavail_landingtype' => null,
	    		'diversion_noanswer_duration' => null
	    );
	    $mockedCallOriginator->expects($this->once())
	                         ->method('exchangeArray')
	                         ->with( $data)
	                         ->will($this->returnValue(null));
	     
	    $mockedCallOwner = $this->getMockBuilder('PbxAgi\Entity\CallOwnerEntity')
	    ->disableOriginalConstructor()
	    ->getMock();
	    
	    $mockedCallOwner->expects($this->once())
	    ->method('exchangeArray')
	    ->with($data)
	    ->will($this->returnValue(null));
	     
	    
	    $this->mockedCall->expects($this->once())
	                           ->method('getCallOwner')
	                           ->with()
	                           ->will($this->returnValue($mockedCallOwner));
	    
	    $this->mockedCall->expects($this->once())
	                           ->method('getCallOriginator')
	                           ->with()
	                           ->will($this->returnValue($mockedCallOriginator));
	    
 	    
	    
	    $this->assertSame($this->mockedCall, $this->prepareCallControllerPlugin->initCall());
	}
	public function testCanSetCallOriginator()
	{
		
	}
	public function testCanSetCallDestinator()
	{
		
	}
}