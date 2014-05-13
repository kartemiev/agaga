<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu;

use PAGI\Node\Node;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;

class NewConferencePinValidator implements NodeCmdValidatorInterface
{
    const PIN_LENGTH = 4;
    public function validate(Node $node)
    {
        $pin = $node->getInput();
        $result = (self::PIN_LENGTH == strlen($pin));
        return  $result;
     }
}