<?php
namespace Vpbxui\FaxUser\Model;

interface FaxUserTableInterface
{
	function fetchAll($filter=null);	
	function getFaxUser($id);
	function saveFaxUser(FaxUser $faxuser);
	function deleteFaxUser($id);
}