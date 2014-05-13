<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

interface AbstractCursorChoiceInterface
{
	function getCursorContainer();
	function getAgi();	
	function getAppConfig();
	function getShortDialTable();
	function setCursorContainer($cursorContainer);
	function getPlayCurrentItem();	
	function setAgi($agi);
	function setAppConfig($appConfig);
	function setShortDialTable($shortDialTable);
    function setPlayCurrentItem($playCurrentItem);
    function setNodeController($nodeController);
    function getCall();    
    function setCall($call);
      
}