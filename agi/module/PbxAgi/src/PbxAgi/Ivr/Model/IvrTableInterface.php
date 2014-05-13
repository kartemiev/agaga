<?php
namespace PbxAgi\Ivr\Model;

interface IvrTableInterface
{
	function fetchAll($filter = null, $limit = null);	
  	function getIvr($id);	  
}