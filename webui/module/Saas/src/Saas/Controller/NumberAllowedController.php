<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Session\Container as SessionContainer;
use Saas\NumberAllowed\Form\NumberAllowedForm;
use Saas\NumberAllowed\Model\NumberAllowed;
use Zend\View\Model\JsonModel;

class NumberAllowedController extends AbstractRestfulController
{
    private $wizardSessionContainer;
    public function __construct(SessionContainer $wizardSessionContainer)
    {
        $this->wizardSessionContainer = $wizardSessionContainer;
    }
    public function replaceList($data)
    {
        $numberAllowed = new NumberAllowed();
        foreach ($data as $numberRange)
        {
            $numberAllowed->append($numberRange);
        }
        $this->wizardSessionContainer->numberAllowed = $numberAllowed;
        return new JsonModel(array('success'=>true,'data'=>$numberAllowed->getArrayCopy()));
    }
}