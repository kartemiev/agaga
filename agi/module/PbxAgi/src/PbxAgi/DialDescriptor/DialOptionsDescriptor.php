<?php

namespace PbxAgi\DialDescriptor;

use PbxAgi\DialDescriptor\DialOptions\AnnouncementDialOptionInterface;
use PbxAgi\DialDescriptor\DialOptionInterface;
use PbxAgi\DialDescriptor\DialOptions\PostConnectDtmfDialOptionInterface;
use PbxAgi\DialDescriptor\DialOptions\ExecExtenAfterCallerHangupDialOptionInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use PbxAgi\DialDescriptor\DialOptions\LimitCallWithWarningDialOptionInterface;
use PbxAgi\DialDescriptor\DialOptions\ExecuteMacroDialOptionInterface;
use PbxAgi\DialDescriptor\DialOptions\RingingMohDialOptionDialOptionInterface;
use PbxAgi\DialDescriptor\DialOptions\DeletePmIntroductionDialOptionInterface;
use PbxAgi\DialDescriptor\DialOptions\RingBackDahdiDialOptionInterface;
use PbxAgi\DialDescriptor\DialOptions\PrivacyManagerDialOptionInterface;
use PbxAgi\DialDescriptor\DialOptions\HangupAfterDialOptionInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DialOptionsDescriptor  implements ServiceLocatorAwareInterface {
    public $announcement;
    public $resetCdr;
    public $answeredElseWhere;
    public $postConnectDtmf;
    public $featureWhileDialing;
    public $callHangupExtenOnPeer;
    public $execExtenAfterCallerHangup;
    public $callerIdBasedOnDialplanHint;
    public $postConnectDialPlanTransferBothTo;
    public $jumpNextPriorityAfterConnect;
    public $callerHangupStarKey;
    public $calleeHangupStarKey;
    public $ignoreForwarding;
    public $jumpToPriority;
    public $allowCallingCallPark;
    public $allowCalledCallPark;
    public $limitCallWithWarning;
    public $executeMacro;
    public $ringingMoh;
    public $disableCallScreening;
    public $deletePmIntroduction;
    public $ringBackDahdi;
    public $sendOriginalCallerId;
    public $privacyManager;
    public $screeningMode;
    public $ringingIndicationBristuff;
    public $ringingIndication;
    public $hangupAfter;
    public $allowCallerTransfer;
    public $allowCalleeTransfer;
    public $execSub;
    public $allowCallerAutomon;
    public $allowCalleeAutomon;
    public $allowCallerAutomixer;
    public $allowCalleeAutomixer;
                 
    protected $serviceLocator;
    
    public function getPublicVars () {
    	return call_user_func('get_object_vars', $this);
    }
    
    public function __toString()
    {       
        return implode('', array_values($this->getPublicVars()));
    }
    
	public function getAnnouncement()
    {
        if (!$this->announcement)
        	{
        		$this->announcement = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AnnouncementDialOption');
        	}
        return $this->announcement;
    }

	public function getResetCdr()
    {
        if (!$this->resetCdr)
        	{
        		$this->resetCdr = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\ResetCDRDialOption');
        	}
        return $this->resetCdr;
    }

	public function getAnsweredElseWhere()
    {
        if (!$this->answeredElseWhere)
        	{
        		$this->answeredElseWhere = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AnsweredElseWhereDialOption');
        	}
        return $this->answeredElseWhere;
    }

	public function getPostConnectDtmf()
    {
        if (!$this->postConnectDtmf)
        	{
        		$this->postConnectDtmf = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\PostConnectDtmfDialOption');
        	}
        return $this->postConnectDtmf;
    }

	public function getFeatureWhileDialing()
    {
        if (!$this->featureWhileDialing)
        	{
        		$this->featureWhileDialing = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\FeatureWhileDialingDialOption');
        	}
        return $this->featureWhileDialing;
    }

	public function getCallHangupExtenOnPeer()
    {
        if (!$this->callHangupExtenOnPeer)
        	{
        		$this->callHangupExtenOnPeer = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\CallHangupExtenOnPeerDialOption');
        	}
        return $this->callHangupExtenOnPeer;
    }

	public function getExecExtenAfterCallerHangup()
    {
        if (!$this->execExtenAfterCallerHangup)
        	{
        		$this->execExtenAfterCallerHangup = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\ExecExtenAfterCallerHangupDialOption');
        	}
        return $this->execExtenAfterCallerHangup;
    }

	public function getCallerIdBasedOnDialplanHint()
    {
        if (!$this->callerIdBasedOnDialplanHint)
        	{
        		$this->callerIdBasedOnDialplanHint = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\CallerIdBasedOnDialplanHintDialOption');
        	}
        return $this->callerIdBasedOnDialplanHint;
    }

	public function getPostConnectDialPlanTransferBothTo()
    {
        if (!$this->postConnectDialPlanTransferBothTo)
        	{
        		$this->postConnectDialPlanTransferBothTo = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\PostConnectDialPlanTransferBothToDialOption');
        	}
        return $this->postConnectDialPlanTransferBothTo;
    }

	public function getJumpNextPriorityAfterConnect()
    {
        if (!$this->jumpNextPriorityAfterConnect)
        	{
        		$this->jumpNextPriorityAfterConnect = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\JumpNextPriorityAfterConnectDialOption');
        	}
        return $this->jumpNextPriorityAfterConnect;
    }

	public function getCallerHangupStarKey()
    {
        if (!$this->callerHangupStarKey)
        	{
        		$this->callerHangupStarKey = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\CallerHangupStarKeyDialOption');
        	}
        return $this->callerHangupStarKey;
    }

	public function getCalleeHangupStarKey()
    {
        if (!$this->calleeHangupStarKey)
        	{
        		$this->calleeHangupStarKey = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\CalleeHangupStarKeyDialOption');
        	}
        return $this->calleeHangupStarKey;
    }

	public function getIgnoreForwarding()
    {
        if (!$this->ignoreForwarding)
        	{
        		$this->ignoreForwarding = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\IgnoreForwardingDialOption');
        	}
        return $this->ignoreForwarding;
    }

	public function getJumpToPriority()
    {
        if (!$this->jumpToPriority)
        	{
        		$this->jumpToPriority = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\JumpToPriorityDialOption');
        	}
        return $this->jumpToPriority;
    }

	public function getAllowCallingCallPark()
    {
        if (!$this->allowCallingCallPark)
        	{
        		$this->allowCallingCallPark = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AllowCallingCallParkDialOption');
        	}
        return $this->allowCallingCallPark;
    }

	public function getAllowCalledCallPark()
    {
        if (!$this->allowCalledCallPark)
        	{
        		$this->allowCalledCallPark = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AllowCalledCallParkDialOption');
        	}
        return $this->allowCalledCallPark;
    }

	public function getLimitCallWithWarning()
    {
        if (!$this->limitCallWithWarning)
        	{
        		$this->limitCallWithWarning = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\LimitCallWithWarningDialOption');
        	}
        return $this->limitCallWithWarning;
    }

	public function getExecuteMacro()
    {
        if (!$this->executeMacro)
        	{
        		$this->executeMacro = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\ExecuteMacroDialOption');
        	}
        return $this->executeMacro;
    }

	public function getRingingMoh()
    {
        if (!$this->ringingMoh)
        	{
        		$this->ringingMoh = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\RingingMohDialOption');
        	}
        return $this->ringingMoh;
    }

	public function getDisableCallScreening()
    {
        if (!$this->disableCallScreening)
        	{
        		$this->disableCallScreening = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\DisableCallScreeningDialOption');
        	}
        return $this->disableCallScreening;
    }

	public function getDeletePmIntroduction()
    {
        if (!$this->deletePmIntroduction)
        	{
        		$this->deletePmIntroduction = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\DeletePMIntroductionDialOption');
        	}
        return $this->deletePmIntroduction;
    }

	public function getRingBackDahdi()
    {
        if (!$this->ringBackDahdi)
        	{
        		$this->ringBackDahdi = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\RingBackDahdiDialOption');
        	}
        return $this->ringBackDahdi;
    }

	public function getSendOriginalCallerId()
    {
        if (!$this->sendOriginalCallerId)
        	{
        		$this->sendOriginalCallerId = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\SendOriginalCallerIdDialOption');
        	}
        return $this->sendOriginalCallerId;
    }

	public function getPrivacyManager()
    {
        if (!$this->privacyManager)
        	{
        		$this->privacyManager = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\PrivacyManagerDialOption');
        	}
        return $this->privacyManager;
    }

	public function getScreeningMode()
    {
        if (!$this->screeningMode)
        	{
        		$this->screeningMode = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\ScreeningModeDialOption');
        	}
        return $this->screeningMode;
    }

	public function getRingingIndicationBristuff()
    {
        if (!$this->ringingIndicationBristuff)
        	{
        		$this->ringingIndicationBristuff = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\RingingIndicationBristuffDialOption');
        	}
        return $this->ringingIndicationBristuff;
    }

	public function getRingingIndication()
    {
        if (!$this->ringingIndication)
        	{
        		$this->ringingIndication = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\RingingIndicationDialOption');
        	}
        return $this->ringingIndication;
    }

	public function getHangupAfter()
    {
        if (!$this->hangupAfter)
        	{
        		$this->hangupAfter = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\HangupAfterDialOption');
        	}
        return $this->hangupAfter;
    }

	public function getAllowCallerTransfer()
    {
        if (!$this->allowCallerTransfer)
        	{
        		$this->allowCallerTransfer = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AllowCallerTransferDialOption');
        	}
        return $this->allowCallerTransfer;
    }

	public function getAllowCalleeTransfer()
    {
        if (!$this->allowCalleeTransfer)
        	{
        		$this->allowCalleeTransfer = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AllowCalleeTransferDialOption');
        	}
        return $this->allowCalleeTransfer;
    }

	public function getExecSub()
    {
        if (!$this->execSub)
        	{
        		$this->execSub = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\ExecSubDialOption');
        	}
        return $this->execSub;
    }

	public function getAllowCallerAutomon()
    {
        if (!$this->allowCallerAutomon)
        	{
        		$this->allowCallerAutomon = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomonDialOption');
        	}
        return $this->allowCallerAutomon;
    }

	public function getAllowCalleeAutomon()
    {
        if (!$this->allowCalleeAutomon)
        	{
        		$this->allowCalleeAutomon = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomonDialOption');
        	}
        return $this->allowCalleeAutomon;
    }

	public function getAllowCallerAutomixer()
    {
        if (!$this->allowCallerAutomixer)
        	{
        		$this->allowCallerAutomixer = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomixerDialOption');
        	}
        return $this->allowCallerAutomixer;
    }

	public function getAllowCalleeAutomixer()
    {
        if (!$this->allowCalleeAutomixer)
        	{
        		$this->allowCalleeAutomixer = $this->serviceLocator->get('PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomixerDialOption');
        	}
        return $this->allowCalleeAutomixer;
    }

 
	public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }    
    
 }   