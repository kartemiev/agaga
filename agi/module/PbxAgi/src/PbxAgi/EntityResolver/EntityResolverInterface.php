<?php
namespace PbxAgi\EntityResolver;

interface EntityResolverInterface
{
	function resolve(ResolveResult $resolveresult = null);
	function setOptions($options);
	function getOptions();
	function setElementChain($elementChain);
	function getElementChain();
	function setInitialValue($value);
	function getInitialValue();
	function getSearchResult();	
}