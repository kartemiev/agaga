<?php
namespace PbxAgiTest\Peer\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\Peer\Model\PeerTable;
 
class PeerTableTest extends PHPUnit_Framework_TestCase
{
 public function testCanRetrieveAPeerByItsName()
    {
        $data = array(		          
            'id'=>1,
            'extension'=>'',
            'extensiongroup'=>1,    
            '$extensiontype'=>'',
            'name'=>'',    
            'outgoingcallspermission'=>'',    
            'transfer'=>'',    
            'statuschange'=>'',    
            'incoming'=>'',    
            'hold'=>'',    
            'forwarding'=>'',    
            'memberofcallcentreque'=>'',
            'mailbox'=>'',    
            'callsequence'=>'',
            'number_status'=>'',
            'extensionrecord'=>'',    
            'peertype'=>'',
            'diversion_unconditional_status'=>'',
            'diversion_unconditional_number'=>'',
            'diversion_unavail_status'=>'',
            'diversion_unavail_number'=>'',
            'diversion_busy_status'=>'',
            'diversion_busy_number'=>'',
            'diversion_noanswer_status'=>'',
            'diversion_noanswer_number'=>'',    
            'diversion_unconditional_landingtype'=>'',    
            'diversion_busy_landingtype'=>'',
            'diversion_noanswer_landingtype'=>'',
            'diversion_unavail_landingtype'=>'',
            'diversion_noanswer_duration'=>''
        );        
                 
    	$peer = new Extension();
    	$peer->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Extension());
    	$resultSet->initialize(array($peer));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('name'=>'100000'))
    	                 ->will($this->returnValue($resultSet));
    
    	$peerTable = new PeerTable($mockTableGateway);
    
    	$this->assertSame($peer, $peerTable->getPeer('100000'));
    } 
    public function testGetPeerByNameThrowsExceptionWhenPeerIdNotExists()
    {
    	$peer = new Extension();
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Extension());
    	$resultSet->initialize(array());
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('name'=>'100000'))
    	                 ->will($this->returnValue($resultSet));
    
    	$peerTable = new PeerTable($mockTableGateway);
        	
    	try
    	{
            $peerTable->getPeer('100000');
    	}
    	catch (\Exception $e)
    	{
    		$this->assertSame("Could not find peer 100000", $e->getMessage());
    		return;
    	}
    	
    	$this->fail('Expected exception was not thrown');
    	
    }
    public function testCanRetrieveAPeerByItsExtenNum()
    {
    	$data = array(
    			'id'=>1,
    			'extension'=>'',
    			'extensiongroup'=>1,
    			'$extensiontype'=>'',
    			'name'=>'',
    			'outgoingcallspermission'=>'',
    			'transfer'=>'',
    			'statuschange'=>'',
    			'incoming'=>'',
    			'hold'=>'',
    			'forwarding'=>'',
    			'memberofcallcentreque'=>'',
    			'mailbox'=>'',
    			'callsequence'=>'',
    			'number_status'=>'',
    			'extensionrecord'=>'',
    			'peertype'=>'',
    			'diversion_unconditional_status'=>'',
    			'diversion_unconditional_number'=>'',
    			'diversion_unavail_status'=>'',
    			'diversion_unavail_number'=>'',
    			'diversion_busy_status'=>'',
    			'diversion_busy_number'=>'',
    			'diversion_noanswer_status'=>'',
    			'diversion_noanswer_number'=>'',
    			'diversion_unconditional_landingtype'=>'',
    			'diversion_busy_landingtype'=>'',
    			'diversion_noanswer_landingtype'=>'',
    			'diversion_unavail_landingtype'=>'',
    			'diversion_noanswer_duration'=>''
    	);
    	 
    	$peer = new Extension();
    	$peer->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Extension());
    	$resultSet->initialize(array($peer));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	->method('select')
    	->with(array('extension'=>'100'))
    	->will($this->returnValue($resultSet));
    
    	$peerTable = new PeerTable($mockTableGateway);
    
    	$this->assertSame($peer, $peerTable->getPeerByExtenNum('100'));
    }
}