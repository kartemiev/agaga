<?php
namespace Vpbxui\Route\Model;

 
interface RouteTableInterface
{
	function fetchAll($filter=null);
	function getRoute($id);
	function saveRoute(Route $route);
	function deleteRoute($id);
    function updateDefaultFileldsResetDefault();
    function deleteAllRoutes();
    
}