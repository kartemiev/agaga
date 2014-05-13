<?php
namespace PbxAgi\Service\ConferenceMenu;

use PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\BuildCreateConferenceMenu;
use PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\BuildPasswordCreateMenu;
use PAGI\Node\NodeController;
use PbxAgi\Service\ConferenceMenu\Hangup\BuildHangupNode;
use PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\BuildConferencePromptScopeMenu;

class CreateMainMenu
{
    protected $buildCreateConferenceMenu;
    protected $buildPasswordCreateMenu;
    protected $nodeController;
    protected $buildHangupNode;
    protected $buildConferencePromptScopeMenu;
    public function __construct(
        BuildCreateConferenceMenu $buildCreateConferenceMenu, 
        BuildPasswordCreateMenu $buildPasswordCreateMenu, 
        NodeController $nodeController,
		BuildHangupNode $buildHangupNode,
        BuildConferencePromptScopeMenu $buildConferencePromptScopeMenu
		)
        {
            $this->buildCreateConferenceMenu = $buildCreateConferenceMenu;
            $this->buildPasswordCreateMenu = $buildPasswordCreateMenu;
            $this->nodeController = $nodeController;
            $this->buildHangupNode = $buildHangupNode;
            $this->buildConferencePromptScopeMenu = $buildConferencePromptScopeMenu;
        }
     public function __invoke()
     {
         $nodeController = $this->nodeController;
         call_user_func($this->buildCreateConferenceMenu, $nodeController);
         call_user_func($this->buildPasswordCreateMenu, $nodeController);
         call_user_func($this->buildHangupNode, $nodeController);
         call_user_func($this->buildConferencePromptScopeMenu, $nodeController);
     }   
     public function getNodeController()
     {
         return $this->nodeController;
     }
}