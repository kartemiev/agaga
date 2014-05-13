<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PAGI\Exception\ChannelDownException;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\Entity\CallEntityInterface;
use PbxAgi\Service\ConferenceMenu\JoinMainMenu;
use PbxAgi\Service\ConferenceMenu\CreateMainMenu;

class ConferenceController extends AbstractActionController
{
    protected $agi;
    protected $call;
    protected $varManager;
    protected $joinMainMenu;
    protected $createMainMenu;  
    public function __construct(
        $agi, 
        CallEntityInterface $call, 
        ChannelVarManagerInterface $varManager,
        JoinMainMenu $joinMainMenu,
        CreateMainMenu $createMainMenu
        )
    {
        $this->agi = $agi;
        $this->call = $call;
        $this->varManager = $varManager;
        $this->joinMainMenu = $joinMainMenu;
        $this->createMainMenu = $createMainMenu;	
    }  
    public function joinAction()
    {
         $this->init();
        $joinMainMenu = $this->joinMainMenu;
        $nodeController = $joinMainMenu->getNodeController();
        try{
            $joinMainMenu();
            $agi = $this->agi;
            $agi->answer();
            $nodeController->jumpTo('conferenceJoinMenu');
        } catch (ChannelDownException $e){};
    }

    public function createAction()
    {
        $this->init();
        $createMainMenu = $this->createMainMenu;
        $nodeController = $createMainMenu->getNodeController();
        try{
            $createMainMenu();
            $agi = $this->agi;
            $agi->answer();
            $nodeController->jumpTo('conferenceCreateMenu');
        } catch (ChannelDownException $e){};
    }
       
    protected function init()
    {
        $this->call = $this->PrepareCallControllerPlugin()
                           ->initCall();
     }
     
}