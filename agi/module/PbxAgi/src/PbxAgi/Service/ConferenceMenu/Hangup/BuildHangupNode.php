<?php
namespace PbxAgi\Service\ConferenceMenu\Hangup;

use PAGI\Node\NodeController;
use PbxAgi\Service\BuildAbstractMenu\BuildGenericNode;
use PbxAgi\Service\ConferenceMenu\Hangup\HangupCommand;
use PbxAgi\Service\Closurize;

class BuildHangupNode
{
	protected $buildGenericNode;
	protected $hangupCommand;
	protected $closurize;
	public function __construct(
			BuildGenericNode $buildGenericNode,
			Closurize $closurize,
			HangupCommand $hangupCommand
			)
	{
	    $this->buildGenericNode = $buildGenericNode;
	    $this->closurize = $closurize;	    
	    $this->hangupCommand = $hangupCommand;
	}
	public function __invoke(NodeController $nodeController)
	{
		$closurize = $this->closurize;
		$hangupAction = $closurize(
				array($this->hangupCommand,'__invoke')
		);		
		$buildGenericNode = $this->buildGenericNode;
		$buildGenericNode('hangupAction', $nodeController)
					->executeBeforeRun($hangupAction);				 
	}
	
}