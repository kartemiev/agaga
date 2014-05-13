<?php
namespace PbxAgiTest\Entity;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\Entity\CallDestinatorEntity;
use PbxAgi\Entity\CallEntity;
use PbxAgi\Entity\CallOwnerEntity;
use PbxAgi\Entity\CallOriginatorEntity;
 
class CallEntityTest extends PHPUnit_Framework_TestCase
{
    public function testCallEntityInitialState()
    {
        
    	$callentity = new CallEntity(new CallOwnerEntity(), new CallOriginatorEntity(), new CallDestinatorEntity());

    	$this->assertNull($callentity->getServiceLocator(), '"serviceLocator" should initially be null');
     	$this->assertInstanceOf('PbxAgi\Entity\CallOwnerEntity',$callentity->getCallOwner(), '"CallOwner" should  be an instance of CallOwnerEntity');
    	$this->assertInstanceOf('PbxAgi\Entity\CallOriginatorEntity',$callentity->getCallOriginator(), '"callOriginator" should  be an instance of CallOriginatorEntity');
    	$this->assertInstanceOf('PbxAgi\Entity\CallDestinatorEntity',$callentity->getCallDestinator(), '"callDestinator" should  be an instance of CallDestinatorEntity');
    	$this->assertNull($callentity->getExten(), '"exten" should initially be null');
    	$this->assertNull($callentity->getError(), '"error" should initially be null');
    	$this->assertNull($callentity->getUniqueid(), '"uniqueid" should initially be null');
    	$this->assertNull($callentity->getTransfered(), '"transfered" should initially be null');
    	
    }
         
    
    public function testSettersAndGettersPerformCorrectly()
    {
        $callOwnerEntity = new CallOwnerEntity();
        $callOriginatorEntity = new CallOriginatorEntity();
        $callDestinatorEntity = new CallDestinatorEntity();
        $callentity = new CallEntity($callOwnerEntity, $callOriginatorEntity, $callDestinatorEntity);                
        $serviceManager = Bootstrap::getServiceManager();
        $serviceManager->setAllowOverride(true);               
        $callentity->setServiceLocator($serviceManager);
        $callentity->setExten('100');
        $callentity->setError(true);
        $callentity->setUniqueid('1267568856.11');
        $callentity->setTransfered(true);
        
        $this->assertInstanceOf('Zend\ServiceManager\ServiceManager', $callentity->getServiceLocator(),'getServiceLocator should return an instance of ServiceLocator');
        $this->assertInstanceOf('PbxAgi\Peer\Model\PeerTable', $callentity->getPeerTable(),'getPeerTable should return instance of peerTable');
        $this->assertSame($callOwnerEntity, $callentity->getCallOwner(), 'getCallOwner should return instance of CallOwnerEntity after constructor invokation');
        $this->assertSame($callOriginatorEntity, $callentity->getCallOriginator(), 'getCallOwner should return instance of CallOwnerEntity after constructor invokation');
        $this->assertSame($callDestinatorEntity, $callentity->getCallDestinator(), 'getCallDestinator should return instance of CallDestinatorEntity after constructor invokation');
        
        $this->assertSame('100', $callentity->getExten(),'extension value has not been set correctly');
        $this->assertSame(true, $callentity->getError() ,'error value has not been set correctly');
        $this->assertSame('1267568856.11', $callentity->getUniqueid() ,'uniqueid value has not been set correctly');
        $this->assertSame(true, $callentity->getTransfered(), 'transferred value has not been set correctly');
        
    }
     
    public function testCallOriginatorDestinatorAndOwnerSettersPerformCorrectly()
    {
        $callentity = new CallEntity(new CallOwnerEntity(), new CallOriginatorEntity(), new CallDestinatorEntity());
        $callentity->setCallOwner(null);
        $callentity->setCallOriginator(null);
        $callentity->setCallDestinator(null);
        $this->assertNull($callentity->getCallOwner(),'CallOwner hasn not been set correctly');
        $this->assertNull($callentity->getCallOriginator(),'CallOriginator has not been set correctly');
        $this->assertNull($callentity->getCallDestinator(),'CallDestinator has not been set correctly');
        
    }
    
    
    
}