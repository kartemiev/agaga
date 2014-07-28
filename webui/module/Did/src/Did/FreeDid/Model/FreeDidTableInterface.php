<?php
namespace Did\FreeDid\Model;

use Agaga\Entity\Did;

interface FreeDidTableInterface
{
	function fetchAll($filter=null);	
    function getDid($id);	
	function saveDid(Did $did);	
	function deleteDid($id);
	function getApiGateway();
}
