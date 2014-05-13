<?php
namespace PbxAgi\Context\Model;

interface ContextTableInterface
{
	function fetchAll($filter = null, $limit = null);	
	function getContext($id);	 
}
