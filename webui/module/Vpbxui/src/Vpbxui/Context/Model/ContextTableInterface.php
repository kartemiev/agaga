<?php
namespace Vpbxui\Context\Model;

interface ContextTableInterface
{
	public function fetchAll($filter=null);
	public function getContext($id);
	public function saveContext(Context $context);
	public function deleteContext($id);
}
