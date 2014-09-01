<?php
namespace Saas\Did\Model;

use Saas\Did\Model\Did;

interface DidTableInterface
{
	function fetchAll($filter=null);	
    function getDid($id);	
	function saveDid(Did $did);	
	function deleteDid($id);
	function getApiGateway();
}
