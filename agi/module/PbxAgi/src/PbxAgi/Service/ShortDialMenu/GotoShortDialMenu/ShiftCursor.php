<?php
namespace PbxAgi\Service\ShortDialMenu\GotoShortDialMenu;

use PAGI\Node\Node;
use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer;
use PbxAgi\ShortDial\Model\ShortDialTable;
use PbxAgi\Entity\CallEntity;
use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\PlayCurrentItem;
use PAGI\Node\NodeController;
class ShiftCursor
{
    protected $cursorContainer;
    protected $shortDialTable;
    protected $call;
    protected $playCurrentItem;
    protected $nodeController;
    public function __construct(
        CursorContainer $cursorContainer, 
        ShortDialTable $shortDialTable,
        CallEntity $call,
        PlayCurrentItem $playCurrentItem,
        NodeController $nodeController
        )
    {
        $this->cursorContainer = $cursorContainer;
        $this->shortDialTable = $shortDialTable;
        $this->call = $call;
        $this->playCurrentItem = $playCurrentItem;
        $this->nodeController = $nodeController;
    }
    public function __invoke(Node $node)
    {
        $shortNum = $node->getInput();
        $peerId = $this->call->getCallOwner()->getId();
        $shortDial = $this->shortDialTable->getShortDialByShort($shortNum, $peerId);
        $shortDialRec = $shortDial->current();
        $this->cursorContainer->setId($shortDialRec->id);
        call_user_func($this->playCurrentItem);        
        $this->nodeController->jumpTo('indexMenu');
    }
}