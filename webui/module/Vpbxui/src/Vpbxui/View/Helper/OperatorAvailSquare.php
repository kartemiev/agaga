<?php
namespace Vpbxui\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
 
class OperatorAvailSquare extends AbstractHelper
{   
     public function __invoke($operatoravailpgarray,$operatornum)
    {
		$operatorsString = trim($operatoravailpgarray,'{}');
    	$operators = explode(',', $operatorsString);
        return  (in_array((string)$operatornum,$operators))?'redbox':'greenbox';
    }
}
