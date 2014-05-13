<?php
namespace PbxAgi\Service\ShortDialMenu\GotoShortDialMenu;

use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;
use PAGI\Node\Node;
use PbxAgi\ShortDial\Model\ShortDialTable;
use PbxAgi\Entity\CallEntityInterface;

class ExistingShortDialValidator implements NodeCmdValidatorInterface
{
    protected $shortDialTable;
    protected $call;
    public function __construct(ShortDialTable $shortDialTable, CallEntityInterface $call)
    {
        $this->shortDialTable = $shortDialTable;
        $this->call = $call;
    }
    
    public function validate(Node $node)
    {
        $shortNumber = $node->getInput();
        $peerId = $this->call->getCallOwner()->getId();               
        $shortDial = $this->shortDialTable->getShortDialByShort($shortNumber, $peerId);
        return ($shortDial->count()>0);
    }
}