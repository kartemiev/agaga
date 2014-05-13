<?php
namespace Vpbxui\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
 
class DispositionDebrief extends AbstractHelper
{   
	protected  $dispositionDebrief = array(
        'ANSWERED'=>'состоялся',
        'FAILED'=> 'отменен',
            'NO ANSWER' =>'неответ',
        'BUSY' => 'занят'
        );    
	protected $dispositionDecoration = array(
			'ANSWERED'=>'<span class="callsuccess">%s</span>',
			'FAILED'=> '%s',
			'NO ANSWER' =>'%s',
			'BUSY' => '%s'		
	);
     public function __invoke($disposition)
    {
    	$dispositionDebrief = $this->dispositionDebrief;
    	$debrief = (isset($dispositionDebrief[$disposition]))?
    				$dispositionDebrief[$disposition]:'';
    	$debriefDecorated = (''==$debrief)?
    						'':
    						sprintf($this->dispositionDecoration[$disposition],$debrief);
        return  $debriefDecorated;
    }
}
