<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PAGI\Exception\ChannelDownException;
use Zend\ServiceManager\InitializerInterface;
 
class ShortDialFeatureController extends AbstractActionController
{
    public  $mainMenu;
    protected $agi;
    protected $cursorContainerInitializer;
    protected $cursorContainer;
    protected $call;
    public function __construct($mainMenu, $agi, InitializerInterface $cursorContainerInitializer, $cursorContainer)
    {
        $this->mainMenu = $mainMenu;
        $this->agi = $agi;
        $this->cursorContainerInitializer = $cursorContainerInitializer;
        $this->cursorContainer = $cursorContainer;
    }
    public function indexAction()
    {
        $this->init();
        $mainMenu = $this->mainMenu;
        $nodeController = $mainMenu->getNodeController();        
        try{
            call_user_func_array(array($this->cursorContainerInitializer,'initialize'),
            array($this->cursorContainer,$this->getServiceLocator()));
             $mainMenu();
            $agi = $this->agi;
            $agi->answer();
            $nodeController->jumpTo('mainMenu');
        } catch (ChannelDownException $e){};
    }
    protected function init()
    {
        $this->call = $this
        ->PrepareCallControllerPlugin()
        ->initCall();
    }
}