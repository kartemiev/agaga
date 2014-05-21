<?php
namespace AgiHelper\RecordedCall\Model;

use AgiHelper\RecordedCall\Model\RecordedCall;

interface  RecordedCallTableInterface
{
	function fetchAll($filter=null, $orderby = null);	
	function getRecordedCall($id);	
	function saveRecordedCall(RecordedCall $recordedcall);	
 	function getTableGateway();
}