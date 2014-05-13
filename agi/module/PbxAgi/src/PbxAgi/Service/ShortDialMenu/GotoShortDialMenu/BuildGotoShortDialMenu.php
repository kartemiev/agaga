<?php
namespace PbxAgi\Service\ShortDialMenu\GotoShortDialMenu;

use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenu;
use PAGI\Node\NodeController;
use PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\ShiftCursor;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;

class BuildGotoShortDialMenu extends BuildAbstractMenu
{
    protected $shiftCursor;
    protected $existingShortDialValidator;
    public function __construct(ShiftCursor $shiftCursor, NodeCmdValidatorInterface $existingShortDialValidator)
    {
        $this->shiftCursor = $shiftCursor;
        $this->existingShortDialValidator = $existingShortDialValidator;
    }
    public function __invoke(NodeController $nodeController)
    {
        $closurize = $this->closurize;
        $appConfig = $this->appConfig;
        $shiftCursor = $closurize(array($this->shiftCursor,'__invoke'));
        $hangup = $closurize(array($this->hangupAndQuit,'run'));
        $existingShortDialValidator = $closurize(array($this->existingShortDialValidator,'validate'));
        $buildGenericNode = $this->buildGenericNode;
        $buildGenericNode('gotoMenu', $nodeController)
            ->saySound('silence/1')
            ->saySound($appConfig->getShortDialEnterSnumGoto())
            ->expectExactly(2)
            ->maxAttemptsForInput(4)
            ->validateInputWith(
                'option',
                 $existingShortDialValidator,
                $appConfig->getShortDialShortDoesntExists()
                    )
            ->executeOnValidInput($shiftCursor);
    
        $nodeController->registerResult('gotoMenu')->onMaxAttemptsReached()
            ->jumpTo('indexMenu');
        ;
 
    }
}