<?php
namespace PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu;

use PAGI\Node\Node;
use PAGI\Node\NodeController;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\ShortDial\Model\ShortDialTable;
use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer;
class DeleteShortDial 
{
    protected $nodeController;
    protected $agi;
    protected $appConfig;
    protected $cursorContainer;
    protected $shortDialTable;
    public function __construct(
        NodeController $nodeController, 
        $agi, 
        AppConfigInterface $appConfig,
        CursorContainer $cursorContainer,
        ShortDialTable $shortDialTable
        )
    {
        $this->nodeController = $nodeController;
        $this->agi = $agi;
        $this->appConfig = $appConfig;
        $this->cursorContainer = $cursorContainer;
        $this->shortDialTable = $shortDialTable;
    }
    public function __invoke(Node $node)
    {        
        $agi = $this->agi;
        $id = $this->cursorContainer->getId();
        $this->shortDialTable->deleteShortDial($id);
        $agi->streamFile('silence/1', Node::DTMF_NONE);
         $agi->streamFile($this->appConfig->getShortDialItemDeleted(), Node::DTMF_NONE);
        $this->nodeController->jumpTo('indexMenu');
    }
}