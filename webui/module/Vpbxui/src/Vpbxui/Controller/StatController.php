<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class StatController extends AbstractActionController
{
    protected $amitable;
     

        public function indexAction() {
//        $amitable = $this->get
    }
    
    
    public function getAmiclient() {
        return $this->amiclient;
    }

    public function setAmiclient($amiclient) {
        $this->amiclient = $amiclient;
    }
    
}