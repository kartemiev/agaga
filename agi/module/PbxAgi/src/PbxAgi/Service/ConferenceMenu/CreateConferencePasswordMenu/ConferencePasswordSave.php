<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu;

use PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainerInterface;
use PAGI\Node\Node;
use PbxAgi\Service\ConferenceMenu\NodeCmdExecuteClosureInterface;

class ConferencePasswordSave implements NodeCmdExecuteClosureInterface
{
    protected $conferenceCredentials;
    public function __construct(ConferenceCredentialsContainerInterface $conferenceCredentials)
    {
        $this->conferenceCredentials = $conferenceCredentials;
    }
    
    public function doRun(Node $node)
    {
        $this->conferenceCredentials
             ->setConfpin($node->getInput());
    }
}