<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
class VoiceMailMainController extends AbstractActionController
{
    protected $agi;
    const AST_VM_MAIN_OPTION_SKIP_NUMBER_PROMPT = 's';
    
    public function __construct($agi)
    {
    	$this->agi = $agi;
    }
    public function indexAction()
    {
        $call = $this->PrepareCallControllerPlugin()
        			 ->initCall();
        $originator = $call->getCallOriginator();
        $mailbox = $originator->getMailbox();
        
        $agi = $this->agi;
        $agi->answer();
        $agi->exec('VoiceMailMain',array(self::AST_VM_MAIN_OPTION_SKIP_NUMBER_PROMPT.$mailbox."@default"));
        $agi->hangup();
    }
}
