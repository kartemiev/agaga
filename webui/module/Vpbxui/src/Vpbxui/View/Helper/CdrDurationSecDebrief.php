<?php
namespace Vpbxui\View\Helper;
 
use Zend\View\Helper\AbstractHelper; 
 
class CdrDurationSecDebrief extends AbstractHelper
{         
     public function __invoke($seconds)
    {    
    	return sprintf('%02d:%02d',$seconds/60,$seconds%60);
    }
}
