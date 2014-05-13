<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
class VoiceMailController extends AbstractActionController
{
    protected $agi;
    public function indexAction()
    {
       
        $agi = $this->getAgi();
        $agi->answer();
        $agi->exec('VoiceMail',array());
        $agi->hangup();
    }   
    protected function getAgi()
    {
        if (!$this->agi)
        {
            $this->agi = $this->getServiceLocator()
                            ->get('ClientImpl');            
        }
        return $this->agi;
    } 
}
