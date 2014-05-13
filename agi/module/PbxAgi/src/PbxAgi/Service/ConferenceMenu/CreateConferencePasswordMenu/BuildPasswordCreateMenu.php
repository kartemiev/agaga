<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu;

use PAGI\Node\NodeController;
use PAGI\Node\Node;
use PbxAgi\Service\Closurize;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Service\ConferenceMenu\NodeCmdExecuteClosureInterface;
use PbxAgi\Service\BuildAbstractMenu\NodeCmdValidatorInterface;
use PbxAgi\Service\BuildAbstractMenu\BuildGenericNode;
 
class BuildPasswordCreateMenu
{   
    protected $closurize; 
    protected $conferencePasswordSave;
    protected $buildGenericNode;
    protected $appConfig;
    protected $newConferencePinValidator;
    public function __construct(Closurize $closurize, 
        NodeCmdExecuteClosureInterface $conferencePasswordSave, 
        BuildGenericNode $buildGenericNode,
        AppConfigInterface $appConfig,
        NodeCmdValidatorInterface $newConferencePinValidator
        )
    {
        $this->closurize = $closurize;
        $this->conferencePasswordSave = $conferencePasswordSave;
        $this->buildGenericNode = $buildGenericNode;
        $this->appConfig = $appConfig;
        $this->newConferencePinValidator = $newConferencePinValidator;
    }
    public function __invoke(NodeController $nodeController)
    {
        $closurize = $this->closurize;
        $conferencePasswordSaveClosure = $closurize(array($this->conferencePasswordSave,'doRun'));
        $newConferencePinValidator = $closurize(array($this->newConferencePinValidator,'validate'));
        $buildGenericNode = $this->buildGenericNode;
        $appConfig = $this->appConfig;
        $buildGenericNode('passwordCreateMenu', $nodeController)
        ->saySound('silence/1')
        ->saySound($appConfig
            ->getConferencePasswordPrompt())
            ->expectAtLeast(4)
            ->expectAtMost(4)
            ->maxAttemptsForInput(255)            
            ->cancelWith(Node::DTMF_STAR)
            ->endInputWith(Node::DTMF_HASH)
            ->validateInputWith('option', $newConferencePinValidator, 
                $appConfig->getConferenceConfPasswordInvalid())
        ->executeOnValidInput($conferencePasswordSaveClosure);
        ;    
    }
}