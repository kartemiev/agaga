<?php
namespace PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu;
 
use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenu;
use PAGI\Node\NodeController;

class BuildDeleteShortDialMenu extends BuildAbstractMenu
 {
     const CHOICE_DELETE_CONFIRM = 1;
     const CHOICE_DELETE_CANCEL = 2;
     public $deleteShortDial;
     public function __construct($deleteShortDial)
     {
         $this->deleteShortDial = $deleteShortDial;
     }
     public function __invoke(NodeController $nodeController)
     {
         $closurize = $this->closurize;
         $appConfig = $this->appConfig;
         $hangup = $closurize(
             array($this->hangupAndQuit,'run')
         );
         $buildGenericNode = $this->buildGenericNode;
         $buildGenericNode('confirmDeleteMenu', $nodeController)
         ->saySound('silence/1')
         ->saySound($appConfig->getShortDialItemDeleteConfirm())
         ->expectExactly(1)             
         ->maxAttemptsForInput(4);
         
          $nodeController->registerResult('confirmDeleteMenu')->onMaxAttemptsReached()
         ->execute($hangup);
         ;
         $nodeController->registerResult('confirmDeleteMenu')->onComplete()
            ->withInput(self::CHOICE_DELETE_CONFIRM)         
                ->execute($closurize(array($this->deleteShortDial,'__invoke')));
         $nodeController->registerResult('confirmDeleteMenu')
            ->withInput(self::CHOICE_DELETE_CANCEL)
                ->jumpTo('indexMenu')   
         ;         
     }
 }
 