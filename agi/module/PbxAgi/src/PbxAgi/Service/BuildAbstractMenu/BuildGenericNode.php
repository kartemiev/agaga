<?php
namespace PbxAgi\Service\BuildAbstractMenu;

use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Node\NodeController;

class BuildGenericNode
{
    protected $appConfig;
    public function __construct(AppConfigInterface $appConfig)
    {
        $this->appConfig = $appConfig;
    }
    public function __invoke($name, NodeController $nodeController)
    {
        $appConfig = $this->appConfig;
        return $nodeController->register($name)
        ->maxTotalTimeForInput(
            $appConfig->getIncomingPstnMenuInputTotalMax()
        )
        ->maxTimeBetweenDigits(
            $appConfig->getIncomingPstnMenuInputBetweenDigitsMax()
        )
        ;
    }
    
}