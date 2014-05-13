<?php
namespace Vpbxui\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CdrCallDateFormat extends AbstractHelper
{
    public function __invoke($cdrdate)
    {
         return  date('d-m-Y H:i:s',strtotime($cdrdate));
    }
}