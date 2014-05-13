<?php
namespace PbxAgi\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\Entity\CallEntityInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;

class PrepareCallControllerPlugin extends AbstractPlugin {
    protected $call;
    public $varManager;
    public function __construct(CallEntityInterface $call,
            ChannelVarManagerInterface $channelVarManger            
            ) {
        $this->varManager = $channelVarManger;        
        $this->call = $call;
    }

    protected function getPeer()
    {
        $peerTable = $this->call->getPeerTable();
        $peer = $this->varManager
                    ->getPeer();
        if ($peer)
        {
            $peerName = $peer->getName();
            $peer =  $peerTable->getPeer($peerName);
        }
        return $peer;
    }
   protected function prepareCall($peer)
    {
        $this->call->setExten(
               $this->varManager->getExten()
               );     
        $this->call->setTransfered(
    		   $this->varManager->isTransfered()
        	   );
        
        $callOwner = $this->call->getCallOwner();
        $callOriginator = $this->call->getCallOriginator();
        $peerExtracted = $peer->getArrayCopy();       
     
        $callOwner->exchangeArray($peerExtracted);       
        $callOriginator->exchangeArray($peerExtracted);
        return $this->call;      
    }
    
     
    public function setCallDestinator($extenNum)
    {
        $peerTable = $this->call->getPeerTable();        
        $peer =  $peerTable->getPeerByExtenNum($extenNum); // destinator by oid!! not by extension
        $peerExtracted = $peer->getArrayCopy();
        $callDestinator = $this->call->getCallDestinator();        
        $callDestinator->exchangeArray($peerExtracted);
        return $this;
    }
    
    public function setCallOriginator($extenNum)
    {
    	$peerTable = $this->call->getPeerTable();
    	$peer =  $peerTable->getPeerByExtenNum($extenNum); // destinator by oid!! not by extension
    	$peerExtracted = $peer->getArrayCopy();
    	$callDestinator = $this->call->getCallDestinator();
    	$callDestinator->exchangeArray($peerExtracted);
    	return $this;
    }
    
    public function initCall()
    {
        $this->varManager->setupOutgoingCall($this->call); //is this right thing to do???
        $peer = $this->getPeer();
        return $this->prepareCall($peer);
    }
}
