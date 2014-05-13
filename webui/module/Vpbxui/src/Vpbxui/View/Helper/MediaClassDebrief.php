<?php
namespace Vpbxui\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
use Vpbxui\MediaRepos\Form\MediaReposForm;
 
/**
 * Returns media class type based on enumerated value (human-way)
 *
 */
class MediaClassDebrief extends AbstractHelper
{         
     public function __invoke($class)
    {
        $debrief = MediaReposForm::$mediaClassDebrief[$class];
        $debrief = (isset($debrief))?$debrief:'';
        return  $debrief;
    }
}
