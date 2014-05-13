<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferenceMenu;

use PAGI\Node\NodeController;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Node\Node;
use PbxAgi\Service\Closurize;
use PbxAgi\Service\BuildAbstractMenu\BuildGenericNode;
use PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer;

class BuildConferencePromptScopeMenu
{
    protected $buildGenericNode;
    protected $appConfig;
    protected $closurize;
    protected $credentialsContainer;
     public function __construct(
     	BuildGenericNode $buildGenericNode, 
        AppConfigInterface $appConfig,
        Closurize $closurize,
     	ConferenceCredentialsContainer $credentialsContainer
         )
    {
        $this->buildGenericNode = $buildGenericNode;
        $this->appConfig = $appConfig;
        $this->closurize = $closurize;
        $this->credentialsContainer = $credentialsContainer; 
     }
    public function __invoke(NodeController $nodeController)
    {
        $appConfig = $this->appConfig;
        $closurize = $this->closurize;        
        $buildGenericNode = $this->buildGenericNode;
        $credentialsContainer = $this->credentialsContainer;                
        $buildGenericNode('promptConferenceScopeMenu', $nodeController)
        			->saySound('silence/1')
        			->saySound($appConfig->getConferenceSelectScopePrompt())
        			->expectAtLeast(1)
        			->expectAtMost(1)
        			->maxAttemptsForInput(10)
         		   ->validateInputWith('option', function($node)
        				{
            				return in_array($node->getInput(), array('1','2'));
        				}           
        			)->executeOnValidInput(
        			function($node) use ($credentialsContainer)
        				{
        					$matchMap = array('1'=>'ALL','2'=>'INTERNALONLY');
        					$credentialsContainer->setJoinAcl($matchMap[$node->getInput()]);
        				}
            	);        
        $menuResult = $nodeController->registerResult('promptConferenceScopeMenu');
        $menuResult->onMaxAttemptsReached()
                    ->jumpTo('hangupAction');
        ;
        $menuResult->onComplete()
        	  	   ->jumpTo('passwordCreateMenu');
        ; 
     
    }
}