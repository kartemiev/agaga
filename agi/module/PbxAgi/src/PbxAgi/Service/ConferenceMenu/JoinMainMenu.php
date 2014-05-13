<?php
namespace PbxAgi\Service\ConferenceMenu;

use PAGI\Node\NodeController;
use PbxAgi\Service\ConferenceMenu\EnterConferenceMenu\BuildConferenceMenu;
use PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu\BuildPasswordMenu;
use PbxAgi\Service\ConferenceMenu\Hangup\BuildHangupNode;

class JoinMainMenu
{
    public $agi;
    public $nodeController;
    public $buildPasswordMenu;
    public $buildConferenceMenu;
    public $buildHangupNode;
    public function __construct(
        $agi,
        NodeController $nodecontroller,
        BuildConferenceMenu $buildConferenceMenu,
        BuildPasswordMenu $buildPasswordMenu,
    	BuildHangupNode $buildHangupNode	
        )
    {
        $this->agi = $agi;
        $this->nodeController  = $nodecontroller;
        $this->buildConferenceMenu = $buildConferenceMenu;
        $this->buildPasswordMenu = $buildPasswordMenu;        
        $this->buildHangupNode = $buildHangupNode;
    }
    public function __invoke()
    {
        $nodeController = $this->nodeController;
        call_user_func($this->buildConferenceMenu, $nodeController);
        call_user_func($this->buildPasswordMenu, $nodeController);
        call_user_func($this->buildHangupNode, $nodeController);
    }
    public function getNodeController()
    {
        return $this->nodeController;    
    }    
}