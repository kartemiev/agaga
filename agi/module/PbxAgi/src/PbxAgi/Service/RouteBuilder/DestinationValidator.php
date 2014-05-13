<?php
namespace PbxAgi\Service\RouteBuilder;

use PbxAgi\RegEntry\Model\RegEntryTableInterface;

class DestinationValidator
{
	protected $regEntryTable;
	protected $number;
	public function __construct(RegEntryTableInterface $regEntryTable)
	{
		$this->regEntryTable = $regEntryTable;
	}
    public function validate($numbermatchid)
    {
    	$regentries = $this->regEntryTable
    		 ->fetchAll(
    		 			array('numbermatchref'=> $numbermatchid)
    					);
    	$found = false;
    	$number = $this->number;
    	foreach ($regentries as $regentry)
    	{
    		$pattern = $regentry->regexpression;
    		$subject = $number;
    		if (1==preg_match($pattern,$subject,$matches))
    		{
    			$found = true;
    			break;
    		}
    	}
    	return $found;    	 
    }
    public function getNumber()
    {
        return $this->number;
    }
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
}