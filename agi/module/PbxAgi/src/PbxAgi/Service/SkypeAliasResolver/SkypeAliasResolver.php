<?php
namespace PbxAgi\Service\SkypeAliasResolver;

use Zend\Mvc\Controller\AbstractActionController;
use PAGI\Exception\ChannelDownException;
use PbxAgi\SkypeAlias\Model\SkypeAliasTableInterface;

class SkypeAliasResolver
{
	protected $skypeAliasTable;
	protected $call;
	public function __construct(SkypeAliasTableInterface $skypeAliasTable)
	{
	    $this->skypeAliasTable = $skypeAliasTable;
	}
    public function resolve($number)
    {
    	$skypealias = $this->skypeAliasTable->getSkypeAliasByExten($number);
    	if ($skypealias)
    	{
    		$result = $skypealias->skypeid;
    	}
    	return isset($result)?$result:null;
    }
}