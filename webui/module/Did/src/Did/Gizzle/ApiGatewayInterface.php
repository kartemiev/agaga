<?php
namespace Did\Gizzle;

use Zend\Stdlib\Hydrator\HydratorInterface;

interface ApiGatewayInterface 
{
	function get($id);
	
	function getList($options = null);
		
	function create($data);
	
	function update($data, $patch = false);
	
	function delete($id);
	
	function deleteList();	
	
	function getArrayObjectPrototype();
	
	function setArrayObjectPrototype($arrayObjectPrototype);
	
	function setDefaultHydrator(HydratorInterface $defaultHydrator);
		
	function getDefaultHydrator();
	
	function getUrl();
	
	function setUrl($url);
	
	function getResult();
	
	function setIdFieldName($idFieldName);
	
	function getIdFieldName();
	
	function setCount($count);
    
    function getCount();
}
