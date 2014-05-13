<?php
namespace PbxAgi\Service\BuildAbstractMenu;

use PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInterface;

abstract class BuildAbstractMenu implements BuildAbstractMenuInterface
{
    protected $closurize;
    protected $hangupAndQuit;
    protected $appConfig;
    protected $buildGenericNode;
 	public function getClosurize()
    {
        return $this->closurize;
    }

	public function getHangupAndQuit()
    {
        return $this->hangupAndQuit;
    }

	public function getAppConfig()
    {
        return $this->appConfig;
    }

	public function setClosurize($closurize)
    {
        $this->closurize = $closurize;
    }

	public function setHangupAndQuit($hangupAndQuit)
    {
        $this->hangupAndQuit = $hangupAndQuit;
    }

	public function setAppConfig($appConfig)
    {
        $this->appConfig = $appConfig;
    }
	public function getBuildGenericNode()
    {
        return $this->buildGenericNode;
    }

	public function setBuildGenericNode($buildGenericNode)
    {
        $this->buildGenericNode = $buildGenericNode;
    }

}