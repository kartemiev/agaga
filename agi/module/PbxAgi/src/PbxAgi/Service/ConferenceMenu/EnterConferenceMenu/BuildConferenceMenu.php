<?php
namespace PbxAgi\Service\ConferenceMenu\EnterConferenceMenu;

use PAGI\Node\NodeController;
use PAGI\Node\Node;
use PbxAgi\Service\ConferenceMenu\ConferenceValidator;
use PbxAgi\Service\Closurize;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Service\ClientImpl\HangupAndQuit;
use PbxAgi\Service\ConferenceMenu\NodeCmdExecuteClosureInterface;
use PbxAgi\Service\BuildAbstractMenu\BuildGenericNode;

class BuildConferenceMenu  {

    protected $conferenceValidator;
    protected $enterConference;
    protected $closurize;
    protected $appConfig;
    protected $hangupAndQuit;
    protected $buildGenericNode;
    
    public function __construct(ConferenceValidator $conferenceValidator, 
        NodeCmdExecuteClosureInterface $enterConference, 
        NodeCmdExecuteClosureInterface $createConference, 
        Closurize $closurize, 
        AppConfigInterface $appConfig,
        HangupAndQuit $hangupAndQuit,
        BuildGenericNode $buildGenericNode
        )
    {
        $this->conferenceValidator = $conferenceValidator;
        $this->enterConference = $enterConference;
         $this->closurize = $closurize;
        $this->appConfig = $appConfig;
        $this->hangupAndQuit = $hangupAndQuit;    
        $this->buildGenericNode = $buildGenericNode;    
    }
    
    public function __invoke(NodeController $nodeController)
    {
    $closurize = $this->closurize;
    $appConfig = $this->appConfig;
    $hangup = $closurize(
        array($this->hangupAndQuit,'run')
    );
     $conferenceValidator = $closurize(
        array($this->conferenceValidator,'validate')
    );
    $enterConference = $closurize(
        array($this->enterConference,'doRun')
    );     
    
    
    
    $buildGenericNode = $this->buildGenericNode;
    
    $buildGenericNode('conferenceJoinMenu', $nodeController)
      ->saySound($appConfig->getConferenceEnterNumPrompt())
    ->expectAtLeast(4)
    ->expectAtMost(4)
    ->maxAttemptsForInput(4)
     ->endInputWith(Node::DTMF_HASH)
    ->validateInputWith('option', $conferenceValidator,
        $appConfig->getConferenceConfNumInvalid()
    )
    ->executeOnValidInput ($enterConference);
    $menuResult = $nodeController->registerResult('conferenceJoinMenu');
    $menuResult->onMaxAttemptsReached()
    ->jumpTo('hangupAction');
    ;
    $menuResult->onComplete()
    ->execute($hangup);
    ;     
     }
}