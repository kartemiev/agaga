<?php
namespace PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu;

use PAGI\Node\Node;
use PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainerInterface;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;
 
class ConferencePasswordValidator implements NodeCmdValidatorInterface
{
    protected $conferenceCredentialsContainer;
    public function __construct(ConferenceCredentialsContainerInterface $conferenceCredentialsContainer)
    {
        $this->conferenceCredentialsContainer = $conferenceCredentialsContainer;        
    }
    public function validate(Node $node)
    {        
        $conferencePasswordRetrived = $this->conferenceCredentialsContainer
                                        ->getConfpin();
        $conferencePasswordEntered =  $node->getInput();
        return ($conferencePasswordEntered == $conferencePasswordRetrived);
    }    
}