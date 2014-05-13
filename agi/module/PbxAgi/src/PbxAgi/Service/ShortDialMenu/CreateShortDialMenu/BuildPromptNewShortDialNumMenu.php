<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenu;
use PAGI\Node\NodeController;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\ShortDialNumChosen;

class BuildPromptNewShortDialNumMenu extends BuildAbstractMenu
{
    protected  $newShortDialValidator;
    protected $createShortDial;
    protected $shortDialNumChosen;
    public function __construct(
        NodeCmdValidatorInterface $newShortDialValidator, 
        ShortDialNumChosen $shortDialNumChosen
         )
    {
        $this->newShortDialValidator = $newShortDialValidator;
        $this->shortDialNumChosen = $shortDialNumChosen;
    }
    public function __invoke(NodeController $nodeController)
    {
        $closurize = $this->closurize;        
        $newShortDialValidator = $closurize(array($this->newShortDialValidator,'validate'));
        $appConfig = $this->appConfig;
        $hangup = $closurize(
            array($this->hangupAndQuit,'run')
        );
        $shortdial = $closurize(array($this->shortDialNumChosen,'__invoke'));
        $buildGenericNode = $this->buildGenericNode;
        $buildGenericNode('createMenu', $nodeController)
        ->saySound('silence/1')
        ->saySound($appConfig->getShortDialEnterShort())
        ->expectExactly(2)
        ->maxAttemptsForInput(4)
        ->validateInputWith('option', $newShortDialValidator,
            $appConfig->getShortDialNumCreateInvalidOrAlreadyExists())
                      ->executeOnValidInput($shortdial);     
           
        $menuResult = $nodeController->registerResult('createMenu');
        $menuResult->onMaxAttemptsReached()
        ->execute($hangup);
        ;
        $menuResult->onComplete()
        ->execute($hangup);
        ;
    }
}