<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenu;
use PAGI\Node\NodeController;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\CreateShortDial;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;

class BuildConfirmSaveShortDialMenu extends BuildAbstractMenu
{
    const CHOICE_DELETE_CONFIRM = 1;
    const CHOICE_DELETE_CANCEL = 2;
    
    protected $createShortDial;
    protected $newShortDialValidator;
    public function __construct(
        CreateShortDial $createShortDial, 
        NodeCmdValidatorInterface $newShortDialValidator)
    {
        $this->createShortDial = $createShortDial;
        $this->newShortDialValidator = $newShortDialValidator;
    }
    public function __invoke(NodeController $nodeController)
    {
        $appConfig = $this->appConfig;
        $closurize = $this->closurize;
        $buildGenericNode = $this->buildGenericNode;
        $createShortDial = $closurize(array($this->createShortDial, '__invoke'));
        $hangup = $closurize(array($this->hangupAndQuit,'run'));
        $newShortDialValidator = $closurize(array($this->newShortDialValidator,'validate'));
        $buildGenericNode('confirmSaveShortDialMenu', $nodeController)
            ->saySound('silence/1')
            ->saySound($appConfig->getConferenceEnterNumPrompt())
            ->expectExactly(1)
            ->maxAttemptsForInput(4);
                 
        $menuResult = $nodeController->registerResult('confirmSaveShortDialMenu');
        $menuResult->onMaxAttemptsReached()
        ->execute($hangup);
        ;
        $menuResult->onComplete()
        ->withInput(self::CHOICE_DELETE_CONFIRM)->execute($createShortDial)
        ->withInput(self::CHOICE_DELETE_CANCEL)->jumpTo('indexMenu')        
        ;
    }
}