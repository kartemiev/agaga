<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use PAGI\Node\NodeController;
use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenu;
class BuildCreateShortDialMenu extends BuildAbstractMenu
{
    const CHOICE_CREATE_NEW_ENTRY = 1;
    const CHOICE_MAIN_MENU = '*';
    const CHOICE_INDEX_MENU = 7; 
 
    public function __invoke(NodeController $nodeController)
    {
        $closurize = $this->closurize;
        $appConfig = $this->appConfig;
        $hangup = $closurize(
            array($this->hangupAndQuit,'run')
        );
        $choiceCurrent = $closurize(array($this->choiceCurrent,'__invoke'));
        
        $buildGenericNode = $this->buildGenericNode;
        $buildGenericNode('indexCreateMenu', $nodeController)
        ->saySound('silence/1')
        ->saySound($appConfig->getShortDialCreateMenuPrompt())     
        ->expectExactly(1)        
         ->maxAttemptsForInput(4);
                      
        $nodeController->registerResult('indexCreateMenu')->onComplete()
        ->withInput(self::CHOICE_CREATE_NEW_ENTRY)->jumpTo('shortDialPromtMenu');
        
        $nodeController->registerResult('indexCreateMenu')->onComplete()
        ->withInput(self::CHOICE_MAIN_MENU)->jumpTo('indexMenu');

        $nodeController->registerResult('indexCreateMenu')->onComplete()
        ->withInput(self::CHOICE_INDEX_MENU)->jumpTo('mainMenu');
        
        
    }
}
 