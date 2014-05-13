<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferenceMenu;

use PAGI\Node\Node;
use PbxAgi\Conference\Model\ConferenceValidator;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;
 
class NewConferenceNumberValidator implements NodeCmdValidatorInterface
{
    protected $conferenceValidator;
     public function __construct(ConferenceValidator $conferenceValidator)
    {
        $this->conferenceValidator = $conferenceValidator;
     }
    public function validate(Node $node)
    {
        $confNumEntered =  $node->getInput();
        
        $isValid = $this->conferenceValidator->isValid($confNumEntered);
        $isVacant = ($isValid)?false:true;
        return $isVacant;
    }
}