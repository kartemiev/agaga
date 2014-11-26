<?php
namespace Saas\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
 
class DidNumberFormat extends AbstractHelper
{   
     public function __invoke($did)
    {
    	if ($did)
    	{
    		$debrief = (preg_match('/^(\d{3})(\d{3})(\d\d)(\d\d)$/',$did->digits,$matches))?
    			sprintf('+7 (%03d) %03d - %02d %02d',$matches[1],$matches[2], $matches[3], $matches[4]):$did->digits;
    	}
    	else
    	{
    		$debrief ='не выбран';    		
    	}
        return  $debrief;
    }
}
