<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use PbxAgi\ShortDial\Model\ShortDialTable;
use PAGI\Node\Node;

class PlayCurrentItem
{
    protected $cursorContainer;
    protected $agi;    
    protected $shortDialTable;
    public function __construct(
        CursorContainerInterface $cursorContainer, 
         $agi,
        ShortDialTable $shortDialTable
        )
    {
        $this->cursorContainer = $cursorContainer;
        $this->agi = $agi;
        $this->shortDialTable  = $shortDialTable;
    }
    public function __invoke()
    {
        $cursorContainer = $this->cursorContainer;
        $id = $this->cursorContainer->getId();
        $shortDialTable = $this->shortDialTable;
        $shortDialRows = $shortDialTable->getShortDialById($id);        
        
        if ($shortDialRows)
        {
            $shortDial = $shortDialRows->current();
            if ($shortDial)
            {
                $short = $shortDial->short;
                $number = $shortDial->number;
                $this->agi->sayNumber($short);
                $this->agi->StreamSilence(1, Node   ::DTMF_NONE);
                $this->agi->sayNumber($number);
            }
        }        
    }
}