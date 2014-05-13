<?php
namespace PbxAgi\NumberMatch\Model;

interface NumberMatchTableInterface
{
	function fetchAll($filter=null,$orderseq=null);
	function getNumberMatch($id);       
}