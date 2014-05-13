<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AlarmPlayController extends AbstractActionController
{
    protected $agi;
    protected $dateTime;
    const REPEAT_TIMES = 2;
    public function __construct($agi, \DateTime $dateTime)
    {
    	$this->agi = $agi;
    	$this->dateTime = $dateTime;
    }
	public function indexAction()
	{
	    $agi = $this->agi;	   
		$agi->answer();
		$dateTime = $this->dateTime;
		for ($repeatCount=1;$repeatCount<=self::REPEAT_TIMES;$repeatCount++)
		  {
 		      $agi->streamFile('silence/1');
		      $agi->sayNumber($dateTime->format('H'));
		      $agi->streamFile('silence/1');		      
		      $agi->sayNumber($dateTime->format('i'));
		      $agi->streamFile('silence/1');		      
	      }
		$agi->hangup();
	}
	public function hangupAction()
	{
 	}
}