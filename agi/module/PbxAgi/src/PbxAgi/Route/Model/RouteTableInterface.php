<?php
namespace PbxAgi\Route\Model;

 
interface RouteTableInterface
{
	function fetchAll($filter=null);
	function getRoute($id);	 
}