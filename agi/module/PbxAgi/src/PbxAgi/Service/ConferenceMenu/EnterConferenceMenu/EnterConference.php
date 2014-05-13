<?php
namespace PbxAgi\Service\ConferenceMenu\EnterConferenceMenu;

use PAGI\Node\Node;
use PbxAgi\Service\ClientImpl\ClientImplInterface;
use PbxAgi\Conference\Model\ConferenceTableInterface;
use PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer;
use PbxAgi\Service\ClientImpl\HangupAndQuit;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Service\ConferenceMenu\NodeCmdExecuteClosureInterface;
use PAGI\Node\NodeController;
use PbxAgi\Entity\CallEntityInterface;

class EnterConference implements NodeCmdExecuteClosureInterface { 
    protected $agi;
    protected $conferenceTable;
    protected $conferenceCredentialsContainer;
    protected $hangupAndQuit;
    protected $nodeController;
    protected $call;
    protected $appConfig;
    public function __construct($agi, 
        ConferenceTableInterface $conferenceTable,
        ConferenceCredentialsContainer $conferenceCredentialsContainer,
        HangupAndQuit $hangupAndQuit,
        NodeController $nodeController,
    	CallEntityInterface $call,
    	AppConfigInterface $appConfig
        )
    {
        $this->agi = $agi;
        $this->conferenceTable = $conferenceTable;
        $this->hangupAndQuit = $hangupAndQuit;
        $this->conferenceCredentialsContainer = $conferenceCredentialsContainer;
        $this->nodeController = $nodeController;
        $this->call = $call;
        $this->appConfig = $appConfig;
    }
    public function doRun(Node $node)
    {
        $confNum = $node->getInput();
        $conferenceCredentialsContainer = $this->conferenceCredentialsContainer;
        $conferenceCredentialsContainer->setConfnumber($confNum);
        $conferenceTable = $this->conferenceTable;
        $conference = $conferenceTable->getConferenceByConfNumber($confNum);
        $conference = $conference->current();
        $conferenceCredentialsContainer->setConfpin($conference->pin);
                
        $this->checkPstnAllowed($conference);        
        
        if (AppConfigInterface::CONF_IS_PROTECTED_TRUE == $conference->isprotected)
        {
            $conferenceCredentialsContainer->setConfpin($conference->pin);
            $this->nodeController->jumpTo('passwordMenu');
        }
        $conference->lastentered=date('Y-m-d H:i:s');
        $conferenceTable->saveConference($conference);
        $agi = $this->agi;
        $agi->exec('Set',array('CONFBRIDGE(user,admin)=yes'));
        $agi->exec('ConfBridge',array($confNum,'',"user"));
        $this->hangupAndQuit->run();
    }
    protected function checkPstnAllowed($conference)
    {
        $peertype = $this->call
        	 			 ->getCallOriginator()
        	 			 ->getPeertype();
        $agi = $this->agi;
        if (AppConfigInterface::DB_PEER_TYPE_TRUNK == $peertype)
        {
            if (AppConfigInterface::DB_CONFERENCE_JOIN_ACL_INTERNALONLY==$conference->joinacl)
            {
               $agi->streamFile('silence/1',Node::DTMF_NONE);
               $agi->streamFile(
               					$this->appConfig
               						  ->getConferenceEnterPstnDisallowedNotice(),
               					Node::DTMF_NONE
        						);
               $agi->streamFile('silence/1',Node::DTMF_NONE);  
               $this->nodeController
               		->jumpTo('conferenceJoinMenu');                
            }
        }
    }
}