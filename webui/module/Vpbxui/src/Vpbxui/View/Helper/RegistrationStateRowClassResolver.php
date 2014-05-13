<?php
namespace Vpbxui\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
 
class RegistrationStateRowClassResolver extends AbstractHelper
{   
    protected $registrationStateDebrief = array(
                  'Registered'=>'trunkregisteredrow',
                    'Unregistered'=>'trunkunregisteredrow'
    			);
    
     public function __invoke($state)
    {
    	if (isset($state)){
        	$debrief = $this->registrationStateDebrief[$state];
        	$debrief = (isset($debrief))?$debrief:'';
        	return  $debrief;
    	}
    }
}
