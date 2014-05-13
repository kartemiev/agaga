<?php
namespace PbxAgi\Service\ConferenceMenu\Hangup;

class HangupCommand
{
	public $agi;
    public function __construct($agi)
    {
        $this->agi = $agi;
    }
    public function __invoke()
    {    	
        $this->agi->hangup();
    }
}