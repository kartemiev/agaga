<?php
namespace PbxAgi\Service\ShortDialMenu;

use PAGI\Node\NodeController;
use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\BuildIndexShortDialMenu;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildCreateShortDialMenu;
use PbxAgi\Service\ShortDialMenu\MainMenu\BuildMainMenu;
use PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu\BuildDeleteShortDialMenu;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildPromptDstNumMenu;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildConfirmSaveShortDialMenu;
use PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\BuildGotoShortDialMenu;
use PbxAgi\Service\ShortDialMenu\ModifyShortDialMenu\BuildModifyShortDialMenu;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildPromptNewAliasNumMenu;

class CreateMainMenu
{
    protected $nodeController;
    protected $buildIndexShortDialMenu;
    protected $buildCreateShortDialMenu;
    protected $buildMainMenu;
    protected $buildDeleteShortDialMenu;
    protected $buildConfirmSaveShortDialMenu;    
    protected $buildGotoShortDialMenu;
    protected $buildModifyShortDialMenu;
    protected $buildPromptNewAliasNumMenu;
    public function __construct(NodeController $nodeController, 
        BuildIndexShortDialMenu $buildIndexShortDialMenu,
        BuildCreateShortDialMenu $buildCreateShortDialMenu,
        BuildMainMenu $buildMainMenu,
        BuildDeleteShortDialMenu $buildDeleteShortDialMenu,
        BuildConfirmSaveShortDialMenu $buildConfirmSaveShortDialMenu,
        BuildGotoShortDialMenu $buildGotoShortDialMenu,
        BuildModifyShortDialMenu $buildModifyShortDialMenu,
    	BuildPromptNewAliasNumMenu $buildPromptNewAliasNumMenu
         )
    {
        $this->nodeController = $nodeController;
        $this->buildCreateShortDialMenu = $buildCreateShortDialMenu;
        $this->buildIndexShortDialMenu = $buildIndexShortDialMenu;
        $this->buildMainMenu = $buildMainMenu;
        $this->buildDeleteShortDialMenu = $buildDeleteShortDialMenu;
         $this->buildConfirmSaveShortDialMenu = $buildConfirmSaveShortDialMenu;
        $this->buildGotoShortDialMenu = $buildGotoShortDialMenu;
        $this->buildModifyShortDialMenu = $buildModifyShortDialMenu;
        $this->buildPromptNewAliasNumMenu = $buildPromptNewAliasNumMenu;
     }
    public function __invoke()
    {
        $nodeController = $this->nodeController;
        call_user_func($this->buildMainMenu, $nodeController);
        call_user_func($this->buildIndexShortDialMenu,$nodeController);        
        call_user_func($this->buildCreateShortDialMenu, $nodeController);
        call_user_func($this->buildDeleteShortDialMenu, $nodeController);
         call_user_func($this->buildConfirmSaveShortDialMenu, $nodeController);
        call_user_func($this->buildGotoShortDialMenu, $nodeController);
        call_user_func($this->buildModifyShortDialMenu, $nodeController);
        call_user_func($this->buildPromptNewAliasNumMenu, $nodeController);
     }
     public function getNodeController()
     {
         return $this->nodeController;
     }     
}