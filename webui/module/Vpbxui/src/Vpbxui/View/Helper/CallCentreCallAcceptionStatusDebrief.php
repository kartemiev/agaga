<?php
namespace Vpbxui\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Returns current operator status based on cdr field (human-way)
 *
 */
class CallCentreCallAcceptionStatusDebrief extends AbstractHelper
{
    protected $callCentreCallAcceptionStatusDebrief = array(
      'default'=>'по умолчанию',
      'FORCE_ENABLED'=>'пропускать вызовы',
      'FORCE_DISABLED'=>'не пропускать вызовы'                
    );
    public function __invoke($status)
    {
        $debrief = $this->callCentreCallAcceptionStatusDebrief[$status];
        $debrief = (isset($debrief))?$debrief:'по умолчанию';
        return  $debrief;
    }
}