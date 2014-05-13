<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferenceMenu;

use PAGI\Node\Node;
use PAGI\Node\NodeController;
use PbxAgi\Conference\Model\ConferenceTable;
use PbxAgi\Conference\Model\Conference;
use PbxAgi\Service\ClientImpl\ClientImpl;
use PbxAgi\Service\ClientImpl\HangupAndQuit;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Service\ConferenceMenu\NodeCmdExecuteClosureInterface;
use PbxAgi\Entity\CallEntityInterface;
use PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer;

class CreateConference implements NodeCmdExecuteClosureInterface
{
    protected $nodeController;
    protected $conferenceTable;
    protected $agi;
    protected $hangupAndQuit;
    protected $call;
    protected $conferenceCredentialsContainer;
    
    public function __construct(NodeController $nodeController, 
        ConferenceTable $conferenceTable,
       $agi,
        HangupAndQuit $hangupAndQuit,
        CallEntityInterface $call,
        ConferenceCredentialsContainer $conferenceCredentialsContainer
        )
    {
        $this->nodeController = $nodeController;
        $this->conferenceTable = $conferenceTable;
        $this->agi = $agi;
        $this->hangupAndQuit = $hangupAndQuit;
        $this->call = $call;
        $this->conferenceCredentialsContainer = $conferenceCredentialsContainer;
    }
    public function doRun(Node $node)
    {      
         
        $this->nodeController->jumpTo('promptConferenceScopeMenu');
        $conferenceTable = $this->conferenceTable;
        $conference = new Conference();
        if ($node->isComplete())
        {
            $conference->confnumber = $node->getInput();
        }       
        $this->injectConferenceAcl($conference)
        	 ->injectConferencePin($conference)
             ->injectConferenceOwner($conference);                
        $lastId = $conferenceTable->saveConference($conference);
        $conference = $conferenceTable->getConferenceById($lastId);    
        $this->sayConferenceNum($conference);        
        $this->injectConferenceDateFirstEntered($conference);         
        $this->enterConference($conference);
    }
    protected function injectConferencePin(Conference $conference)
    {
        
        $pin = $this->conferenceCredentialsContainer->getConfpin();
        $conference->isprotected = (is_null($pin))?
        AppConfigInterface::CONF_IS_PROTECTED_FALSE:
        AppConfigInterface::CONF_IS_PROTECTED_TRUE;
        $conference->pin = (is_null($pin))? '' : $pin;
        return $this;
    }
    protected function injectConferenceAcl(Conference $conference)
    {
        $conference->joinacl = $this->conferenceCredentialsContainer->getJoinacl();
        return $this;
    }
    protected function injectConferenceOwner(Conference $conference)
    {
        $owner = $this->getOwner();
        $conference->ownerref = $owner->getId();
        return $this;
    }
    protected function injectConferenceDateFirstEntered($conference)
    {
        $conference->datefirstentered = date('Y-m-d H:i:s');        
    }
    protected function sayConferenceNum(Conference $conference)
    {
        $agi = $this->agi;
        for ($counter =1;$counter<3;$counter++)
        {
            $agi->sayDigits($conference->confnumber, Node::DTMF_NONE);
            $agi->streamFile('silence/1',Node::DTMF_NONE);
        }
        return $this;
    }
    protected function enterConference(Conference $conference)
    {
        $this->agi
             ->exec('ConfBridge',array($conference->confnumber,'',"user"));
        $this->hangupAndQuit
             ->run();
    }
    protected function getOwner()
    {
        return $this->call->getCallOwner();
    }    
    
}