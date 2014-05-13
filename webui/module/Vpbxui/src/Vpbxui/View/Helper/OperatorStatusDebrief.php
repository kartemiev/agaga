<?php
namespace Vpbxui\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Returns current operator status based on cdr field (human-way)
 *
 */
class OperatorStatusDebrief extends AbstractHelper
{
    protected $operatorstatusdebrief = array(
        'ABSENT'=>'нет на месте',
        'LOGGED_IN'=>'на месте',
        'AWAY_SHORT'=>'на перерыве',
        'AWAY_LUNCH' =>'на обеде');
    public function __invoke($operatorstatus)
    {
        return  $this->operatorstatusdebrief[$operatorstatus];
    }
}