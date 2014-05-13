<?php
namespace Vpbxui\View\Helper;

use Zend\View\Helper\AbstractHelper;

class RegistrationRegistrationtimeConverter extends AbstractHelper
{
    public function __invoke($epoch)
    {
    	if (0==$epoch)
    	{
    	    $result = '';
    	}
    	else
    	{
    		$dt = new \DateTime("@$epoch");    		
    		$result =  $dt->format('H:i:s y/m/Y');
    	}
        return  $result;
    }
}