<?php
namespace Saas\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
 
class ExtensionTypeDebrief extends AbstractHelper
{   
    protected $extensionTypeDebrief = array(
                  'regular'=>'обычный',
                    'operator'=>'оператор'
    );
    
     public function __invoke($extensiontype)
    {
        $debrief = $this->extensionTypeDebrief[$extensiontype];
        $debrief = (isset($debrief))?$debrief:'';
        return  $debrief;
    }
}
