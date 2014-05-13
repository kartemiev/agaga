<?php
namespace Vpbxui\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
 
/**
 * Returns current operator status based on cdr field (human-way)
 *
 */
class CdrScopeDebrief extends AbstractHelper
{   
    protected $cdrScopeDebrief = array(
                  'thishour'=>'30 минут',
                    'today'=>'за сегодня',
        
                  '24hours'=>'за 24 часа',
                  'thismonth'=>'с начала текущего месяца',
                  'past30days' =>'за 30 дней',
    			  'integral'=>''
    );
    
     public function __invoke($scope)
    {
        $debrief = $this->cdrScopeDebrief[$scope];
        $debrief = (isset($debrief))?$debrief:'';
        return  $debrief;
    }
}
