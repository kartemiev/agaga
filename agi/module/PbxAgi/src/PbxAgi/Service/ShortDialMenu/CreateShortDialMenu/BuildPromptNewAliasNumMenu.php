<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenu;
use PAGI\Node\NodeController;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;

class BuildPromptNewAliasNumMenu extends BuildAbstractMenu
{
    protected $newShortDialValidator;
    protected $createShortDial;
    public function __construct(NodeCmdValidatorInterface $newShortDialValidator, CreateShortDial $createShortDial)
    {
        $this->newShortDialValidator = $newShortDialValidator;
        $this->createShortDial = $createShortDial;
    }
       public function __invoke(NodeController $nodeController)
       {
           $closurize = $this->closurize;
           $newShortDialValidator = $closurize(array($this->newShortDialValidator,'validate'));
           $closurize = $this->closurize;
           $appConfig = $this->appConfig;
           $hangup = $closurize(
               array($this->hangupAndQuit,'run')
           );
           $createShortDial = $closurize(array($this->createShortDial,'__invoke'));
           $buildGenericNode = $this->buildGenericNode;
           $buildGenericNode('shortDialPromtMenu', $nodeController)
           ->saySound('silence/1')
           ->saySound($appConfig->getConferenceEnterNumPrompt())
           ->expectAtLeast(1)
           ->expectAtMost(15)
           ->maxAttemptsForInput(4)
           ->validateInputWith('option', $newShortDialValidator,
               $appConfig->getShortDialNumCreateInvalidOrAlreadyExists()
           )->executeOnValidInput($createShortDial);
            
           $menuResult = $nodeController->registerResult('shortDialPromtMenu');
           $menuResult->onMaxAttemptsReached()
           ->execute($hangup);
           ;
           $menuResult->onComplete()
           ->execute($hangup);
           ;
       }
}