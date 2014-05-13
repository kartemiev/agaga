<?php
namespace PbxAgi\Service\ShortDialMenu\ModifyShortDialMenu;

use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenu;
use PAGI\Node\NodeController;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\CreateShortDial;

class BuildModifyShortDialMenu extends BuildAbstractMenu
{
    protected $shortDialDstValidator;
    protected $createShortDial;
    public function __construct(
        NodeCmdValidatorInterface $shortDialDstValidator, 
        CreateShortDial $createShortDial
        )
    {
        $this->shortDialDstValidator = $shortDialDstValidator;
        $this->createShortDial = $createShortDial;
    }
    public function __invoke(NodeController $nodeController)
    {
        $closurize = $this->closurize;
        $appConfig = $this->appConfig;
        $createShortDial = $closurize(array($this->createShortDial,'__invoke'));
         $hangup = $closurize(array($this->hangupAndQuit,'run'));
        $shortDialDstValidator = $closurize(array($this->shortDialDstValidator,'validate'));        
        $buildGenericNode = $this->buildGenericNode;
        $buildGenericNode('modifyMenu', $nodeController)
        ->saySound('silence/1')
        ->saySound($appConfig->getShortDialEnterSnumGoto())
        ->expectExactly(2)
        ->maxAttemptsForInput(4)
        ->validateInputWith(
            'option',
            $shortDialDstValidator,
            $appConfig->getShortDialNumDstInvalid()
        )
        ->executeOnValidInput($createShortDial);
        
        $nodeController->registerResult('modifyMenu')->onMaxAttemptsReached()
        ->jumpTo('indexMenu');
        ;
    }
}