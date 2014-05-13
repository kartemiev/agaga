<?php
namespace Vpbxui\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CdrDstNumReplacementSpecialCase extends AbstractHelper
{
	protected $dstDebrief = array(
		'callcentre'=>'колл-центр',
		'vpbx_trunks'=>'транк',
		'vpbx_dialin'=>'приветствие'		
	);
	protected $dstDecoration = array(
			'callcentre'=>'<b>%s</b>',
			'vpbx_trunks'=>'%s',
			'vpbx_dialin'=>'%s'
	);
	
    public function __invoke($cdr)
    {
    	$dstDebrief = $this->dstDebrief;
    	$dcontext = $cdr->dcontext;
		$dst = (isset($dstDebrief[$dcontext]))? 
			sprintf($this->dstDecoration[$dcontext],$dstDebrief[$dcontext]): 
			$cdr->dst;		
    	return  $dst;
    }
}