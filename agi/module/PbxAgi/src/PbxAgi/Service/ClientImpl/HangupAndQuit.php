<?php
namespace PbxAgi\Service\ClientImpl;


class HangupAndQuit
{
    protected $agi;
    public function __construct($agi)
    {
        $this->agi = $agi;
    }
    public function run()
    {
     //   $this->agi->hangup();
       // exit;
     }
}
