<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Extension\Model\ExtensionTableInterface;

class PickupFeatureController extends AbstractActionController
{
    protected $originator;
    protected $agi;
     public function __construct($agi)
    {
     	$this->agi = $agi;
     }
    
    public function pickupAction()
    {
        $agi = $this->agi;
        $agi->answer();
        $agi->exec('pickup');
        $agi->hangup();
    }      
}