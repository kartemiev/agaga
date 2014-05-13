<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferenceMenu;

use PAGI\Node\NodeController;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Node\Node;
use PbxAgi\Service\Closurize;
use PbxAgi\Service\ClientImpl\HangupAndQuit;
use PbxAgi\Service\ConferenceMenu\NodeCmdExecuteClosureInterface;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;
use PbxAgi\Service\BuildAbstractMenu\BuildGenericNode;
 
class BuildCreateConferenceMenu
{
    protected $buildGenericNode;
    protected $appConfig;
    protected $newConferenceNumberValidator;
    protected $closurize;
    protected $hangupAndQuit;
    protected $createConference;
    public function __construct(
    	BuildGenericNode $buildGenericNode, 
        AppConfigInterface $appConfig,
        NodeCmdValidatorInterface $newConferenceNumberValidator,
        Closurize $closurize,
        HangupAndQuit $hangupAndQuit,
        NodeCmdExecuteClosureInterface $createConference
        )
    {
        $this->buildGenericNode = $buildGenericNode;
        $this->appConfig = $appConfig;
        $this->newConferenceNumberValidator = $newConferenceNumberValidator;
        $this->closurize = $closurize;
        $this->hangupAndQuit = $hangupAndQuit;
        $this->createConference = $createConference;
    }
    public function __invoke(NodeController $nodeController)
    {
        $appConfig = $this->appConfig;
        $closurize = $this->closurize;        
        $newConferenceNumberValidator = $closurize(array($this->newConferenceNumberValidator,'validate'));        
        $hangup = $closurize(array($this->hangupAndQuit,'run'));
        $createConference = $closurize(array($this->createConference,'doRun'));
        $buildGenericNode = $this->buildGenericNode;                
        $buildGenericNode('conferenceCreateMenu', $nodeController)
        ->saySound('silence/1')
        ->saySound($appConfig->getConferenceEnterNumPrompt())
        ->expectAtLeast(0)
        ->expectAtMost(4)
        ->maxAttemptsForInput(4)
        ->cancelWith(Node::DTMF_STAR)
        ->endInputWith(Node::DTMF_HASH)
        ->validateInputWith('option', $newConferenceNumberValidator,
            $appConfig->getConferenceConfNumInvalid()
        )->executeOnValidInput($createConference);
        
        $menuResult = $nodeController->registerResult('conferenceCreateMenu');
        $menuResult->onMaxAttemptsReached()
                    ->execute($hangup);
        ;
 
        $menuResult->onCancel()
        ->execute($createConference);
        ;
    }
}