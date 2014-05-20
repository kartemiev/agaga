<?php
namespace PbxAgi\RecordedCall\Model;

interface  RecordedCallTableInterface
{
	function fetchAll($select, $filter,$orderseq);	
	function getCdr($id);
	function getTableGateway();
}