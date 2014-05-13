<?php
namespace PbxAgi\Service\BuildAbstractMenu;

interface BuildAbstractMenuInterface
{
    function getClosurize();
      
    function getHangupAndQuit();
     
    function getAppConfig();
    
    function setClosurize($closurize);
     
    function setHangupAndQuit($hangupAndQuit);
    
    function setAppConfig($appConfig);
    
    function getBuildGenericNode();    
    
    function setBuildGenericNode($buildGenericNode);
     
}