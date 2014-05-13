<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use PAGI\Node\NodeController;
use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenu;
class BuildIndexShortDialMenu extends BuildAbstractMenu
{
    const CHOICE_PREVIOUS_ENTRY = 1;
    const CHOICE_CURRENT_ENTRY = 2;
    const CHOICE_NEXT_ENTRY = 3;
    const CHOICE_DELETE_ENTRY = 4;
    const CHOICE_CREATE_ENTRY = 5;    
    
    const CHOICE_GOTO_ENTRY = 6;
    const CHOICE_MODIFY_ENTRY = 7;
    
    protected $choiceCurrent;
    protected $choiceNext;
    protected $choicePrevious;
    public function __construct($choiceCurrent, $choiceNext, $choicePrevious)
    {
        $this->choiceCurrent = $choiceCurrent;
        $this->choiceNext = $choiceNext;
        $this->choicePrevious = $choicePrevious;
    }
    public function __invoke(NodeController $nodeController)
    {
        $closurize = $this->closurize;
        $appConfig = $this->appConfig;
        $hangup = $closurize(
            array($this->hangupAndQuit,'run')
        );
        $choiceCurrent = $closurize(array($this->choiceCurrent,'__invoke'));
        $choicePrevious = $closurize(array($this->choicePrevious,'__invoke'));
        $choiceNext = $closurize(array($this->choiceNext,'__invoke'));
        
        $buildGenericNode = $this->buildGenericNode;
        $buildGenericNode('indexMenu', $nodeController)
        ->saySound('silence/1')
        ->saySound($appConfig->getShortDialIndexMenuPrompt())     
        ->expectExactly(1)        
         ->maxAttemptsForInput(4);
        
         $nodeController->registerResult('indexMenu')->onMaxAttemptsReached()
        ->execute($hangup);
        ;
        
        $nodeController->registerResult('indexMenu')->onComplete()
            ->withInput(self::CHOICE_PREVIOUS_ENTRY)->execute($choicePrevious);
        
        $nodeController->registerResult('indexMenu')->onComplete()
            ->withInput(self::CHOICE_CURRENT_ENTRY)->execute($choiceCurrent);
        
        $nodeController->registerResult('indexMenu')->onComplete()
            ->withInput(self::CHOICE_NEXT_ENTRY)->execute($choiceNext);
        
        $nodeController->registerResult('indexMenu')->onComplete()
            ->withInput(self::CHOICE_DELETE_ENTRY)->jumpTo('confirmDeleteMenu');
        
        $nodeController->registerResult('indexMenu')->onComplete()
            ->withInput(self::CHOICE_CREATE_ENTRY)->jumpTo('createMenu');
        
        $nodeController->registerResult('indexMenu')->onComplete()
        ->withInput(self::CHOICE_GOTO_ENTRY)->jumpTo('gotoMenu');
        
        $nodeController->registerResult('indexMenu')->onComplete()
        ->withInput(self::CHOICE_MODIFY_ENTRY)->jumpTo('modifyMenu');
        
        
    }
}