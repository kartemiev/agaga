<?php
namespace Saas\View\Helper;

use Zend\View\Helper\AbstractHelper;
class ExtensionRangeFormat extends AbstractHelper
{
    public function __invoke($startNumber)
    {
       $len = strlen($startNumber);
       $fChar = rtrim($startNumber, '0');
       return '<'.$startNumber.'-'.str_pad($fChar, $len,'9',STR_PAD_RIGHT).'>';
    }
}