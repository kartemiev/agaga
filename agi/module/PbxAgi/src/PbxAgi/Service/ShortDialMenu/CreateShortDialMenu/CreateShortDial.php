<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use PAGI\Node\Node;
use PbxAgi\ShortDial\Model\ShortDial;
use PbxAgi\ShortDial\Model\ShortDialTable;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Entity\CallEntityInterface;
use PbxAgi\Service\ShortDialMenu\ShortDialDataContainerInterface;
use PAGI\Node\NodeController;
class CreateShortDial
{
    protected $shortDialTable;
    protected $agi;
    protected $appConfig;
    protected $call;
    protected $shortDialContainer;
    protected $nodeController;
    public function __construct(
        ShortDialTable $shortDialTable, 
        $agi, 
        AppConfigInterface $appConfig, 
        CallEntityInterface $call,
        ShortDialDataContainerInterface $shortDialContainer,
        NodeController $nodeController
        )
    {
        $this->shortDialTable = $shortDialTable;
        $this->agi = $agi;
        $this->appConfig = $appConfig;
        $this->call = $call;
        $this->shortDialContainer = $shortDialContainer;
        $this->nodeController = $nodeController;
    }
    public function __invoke(Node $node)
    {
        $shortDialNumber = $node->getInput();
        $shortDialShort = $this->shortDialContainer->getShort();
        $shortDialTable = $this->shortDialTable;
        $shortDial = new ShortDial();
        $call = $this->call;
        $callOwner = $call->getCallOwner();
        $peerId = $callOwner->getId();
        $oldShortDial = $shortDialTable->getShortDialByShort($shortDialShort,$peerId);
        if ($oldShortDial)
        {
             $oldShortDialRecord = $oldShortDial->current();
            if ($oldShortDialRecord){
                $id = $oldShortDialRecord->id;
                $shortDial->id = $id;    
            }
        }            
        $shortDial->peerid = $peerId;                
        $shortDial->number = $shortDialNumber;
        $shortDial->short = $shortDialShort;
        $shortDialTable->saveShortDial($shortDial);
        
        $agi = $this->agi;
        $agi->streamFile('silence/1', Node::DTMF_NONE);
        $agi->streamFile($this->appConfig->getShortSaveShortIs(), Node::DTMF_NONE);
        $agi->streamFile('silence/1', Node::DTMF_NONE);        
        $agi->sayDigits($shortDialShort);
        $agi->streamFile($this->appConfig->getShortSaveNumberIs(), Node::DTMF_NONE);
        $agi->streamFile('silence/1', Node::DTMF_NONE);        
        $agi->sayDigits($shortDialNumber);        
        $this->nodeController->jumpTo('indexMenu');
    }
}