<?php
namespace PbxAgi\Service\ConferenceMenu;

use PAGI\Node\Node;
use PbxAgi\Conference\Model\ConferenceValidatorInterface;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;
  
class ConferenceValidator implements NodeCmdValidatorInterface

{
    protected $conferenceValidator;
     public function __construct(ConferenceValidatorInterface $conferenceValidator)
    {
        $this->conferenceValidator = $conferenceValidator;
     }
    public function validate(Node $node)
    {
        $conferenceNum = $node->getInput();
         
        return $this->conferenceValidator->isValid($conferenceNum);
    }    
}