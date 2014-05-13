<?php
namespace Vpbxui\View\Helper;
 
use Zend\View\Helper\AbstractHelper;

class ActiveCallCentreStatusProperty extends AbstractHelper
{   
    protected $activeCallCentreStatusPropertyMatch = array(
                  'FORCE_ENABLED'=>'enabled',
                  'FORCE_DISABLED'=>'disabled',
                  'default'=>'default');
     public function __invoke($element)
    {       
        $status = $this->view->callcentrestatus->overridestatus;
        $result = ($this->activeCallCentreStatusPropertyMatch[$status] == $element)?'active':'';
        return  $result;
    }
}