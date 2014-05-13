<?php
namespace Vpbxui\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CdrCallDirection extends AbstractHelper
{
    public function __invoke($cdr)
    {
    	$outgoing = $cdr->dcontext=='vpbx_dialout';    	 
        return  $outgoing;
    }
}