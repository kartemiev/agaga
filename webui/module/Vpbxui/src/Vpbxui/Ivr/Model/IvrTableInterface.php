<?php
namespace Vpbxui\Ivr\Model;

interface IvrTableInterface
{
 	function fetchAll($filter=null);
 	function getIvr($id);
	function saveIvr(Ivr $ivr);
 	function deleteIvr($id);	 
}