<?php
namespace PbxAgi\Service\ShortDialMenu\MainMenu;

use PAGI\Node\NodeController;
use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenu;
use PAGI\Node\Node;

class BuildMainMenu extends BuildAbstractMenu
{   
    public function __invoke(NodeController $nodeController)
    {
        $closurize = $this->closurize;
        $appConfig = $this->appConfig;
        $hangup = $closurize(
            array($this->hangupAndQuit,'run')
        );
        $buildGenericNode = $this->buildGenericNode;
        $buildGenericNode('mainMenu', $nodeController)
        ->saySound($appConfig->getShortDialMainMenuPrompt())
         ->expectExactly(1)
        ->validateInputWith(
            'option',
            function(Node $node) {
                return in_array(
                    $node->getInput(), array('1', '2')
                );
            },
            'pp/50'
                )
 
        ->maxAttemptsForInput(4);
        
         $nodeController->registerResult('mainMenu')->onMaxAttemptsReached()
        ->execute($hangup);
        ;
        
        $nodeController->registerResult('mainMenu')->onComplete()
        ->withInput('1')->jumpTo('indexMenu')
        ;
        $nodeController->registerResult('mainMenu')->onComplete()
        ->withInput('2')->jumpTo('indexCreateMenu');        
        ;
    }
}