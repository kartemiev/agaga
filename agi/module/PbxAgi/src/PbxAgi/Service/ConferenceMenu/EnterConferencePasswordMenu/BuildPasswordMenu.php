<?php
namespace PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu;

use PAGI\Node\NodeController;
use PAGI\Node\Node;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Service\ClientImpl\HangupAndQuit;
use PbxAgi\Service\Closurize;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;
use PbxAgi\Service\BuildAbstractMenu\BuildGenericNode;
 
class BuildPasswordMenu
{
    protected $closurize;
    protected $nodeController;
    protected $conferencePasswordValidator;
    protected $appConfig;
    protected $hangupAndQuit;
    protected $buildGenericNode;
    public function __construct(NodeController $nodeController, 
        NodeCmdValidatorInterface $conferencePasswordValidator,
        AppConfigInterface $appConfig,
        HangupAndQuit $hangupAndQuit,
        BuildGenericNode $buildGenericNode,
        Closurize $closurize
        )
    {
        $this->nodeController = $nodeController;
        $this->conferencePasswordValidator = $conferencePasswordValidator;      
        $this->appConfig = $appConfig;
        $this->hangupAndQuit = $hangupAndQuit;
        $this->buildGenericNode = $buildGenericNode;
        $this->closurize = $closurize;
    }
    public function __invoke()
    {
             $closurize = $this->closurize;
            $appconfig = $this->appConfig;
             
             $conferencePasswordValidatior = $closurize(
                array($this->conferencePasswordValidator,'validate')
            );
            
            $hangup = $closurize(array($this->hangupAndQuit,'run'));
            
            $nodeController = $this->nodeController;
            $buildGenericNode = $this->buildGenericNode;
            $buildGenericNode('passwordMenu', $nodeController)
            ->saySound('silence/1')
            ->saySound($appconfig->getConferencePasswordPrompt())
            ->expectAtLeast(1)
            ->expectAtMost(5)
            ->endInputWith(Node::DTMF_HASH)
            ->maxAttemptsForInput(3)
            ->validateInputWith(
                'option',
                $conferencePasswordValidatior,
                $appconfig->getConferenceConfPasswordInvalid()
            );
             
            $nodeController->registerResult('passwordMenu')
            ->onMaxAttemptsReached()
            ->jumpTo('hangupAction');
            ;
             
    }
}