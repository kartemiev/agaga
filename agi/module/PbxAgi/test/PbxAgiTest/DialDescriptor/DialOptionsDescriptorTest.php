<?php
namespace PbxAgiTest\DialDescriptor;


use PHPUnit_Framework_TestCase;
use PbxAgi\DialDescriptor\DialOptionsDescriptor;
use \PbxAgiTest\Bootstrap;
use Zend\Filter\Word\UnderscoreToCamelCase;


class DialOptionsDescriptorTest extends PHPUnit_Framework_TestCase
{
	
    public function testEachOptionGetterReturnsProperInstance()
    {
    	$serviceManager = Bootstrap::getServiceManager();
    	     	
        $dialOptionsDescriptor = $serviceManager->get('PbxAgi\DialDescriptor\DialOptionsDescriptor');
        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AnnouncementDialOption',$dialOptionsDescriptor->getAnnouncement());
        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AllowCalledCallParkDialOption',$dialOptionsDescriptor->getAllowCalledCallPark());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\ResetCDRDialOption',$dialOptionsDescriptor->getResetCdr());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AnsweredElseWhereDialOption',$dialOptionsDescriptor->getAnsweredElseWhere());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\PostConnectDtmfDialOption',$dialOptionsDescriptor->getPostConnectDtmf());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\FeatureWhileDialingDialOption',$dialOptionsDescriptor->getFeatureWhileDialing());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\CallHangupExtenOnPeerDialOption',$dialOptionsDescriptor->getCallHangupExtenOnPeer());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\ExecExtenAfterCallerHangupDialOption',$dialOptionsDescriptor->getExecExtenAfterCallerHangup());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\CallerIdBasedOnDialplanHintDialOption',$dialOptionsDescriptor->getCallerIdBasedOnDialplanHint());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\PostConnectDialPlanTransferBothToDialOption',$dialOptionsDescriptor->getPostConnectDialPlanTransferBothTo());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\JumpNextPriorityAfterConnectDialOption',$dialOptionsDescriptor->getJumpNextPriorityAfterConnect());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\CallerHangupStarKeyDialOption',$dialOptionsDescriptor->getCallerHangupStarKey());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\CalleeHangupStarKeyDialOption', $dialOptionsDescriptor->getCalleeHangupStarKey());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\IgnoreForwardingDialOption', $dialOptionsDescriptor->getIgnoreForwarding());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\JumpToPriorityDialOption', $dialOptionsDescriptor->getJumpToPriority());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AllowCallingCallParkDialOption', $dialOptionsDescriptor->getAllowCallingCallPark());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AllowCalledCallParkDialOption', $dialOptionsDescriptor->getAllowCalledCallPark());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\LimitCallWithWarningDialOption', $dialOptionsDescriptor->getLimitCallWithWarning());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\ExecuteMacroDialOption', $dialOptionsDescriptor->getExecuteMacro());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\RingingMohDialOption', $dialOptionsDescriptor->getRingingMoh());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\DisableCallScreeningDialOption',$dialOptionsDescriptor->getDisableCallScreening());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\DeletePmIntroductionDialOption',$dialOptionsDescriptor->getDeletePmIntroduction());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\RingBackDahdiDialOption', $dialOptionsDescriptor->getRingBackDahdi());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\SendOriginalCallerIdDialOption', $dialOptionsDescriptor->getSendOriginalCallerId());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\PrivacyManagerDialOption', $dialOptionsDescriptor->getPrivacyManager());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\ScreeningModeDialOption', $dialOptionsDescriptor->getScreeningMode());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\RingingIndicationBristuffDialOption', $dialOptionsDescriptor->getRingingIndicationBristuff());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\RingingIndicationDialOption', $dialOptionsDescriptor->getRingingIndication());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\HangupAfterDialOption', $dialOptionsDescriptor->getHangupAfter());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\RingingIndicationDialOption', $dialOptionsDescriptor->getRingingIndication());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\RingingIndicationBristuffDialOption', $dialOptionsDescriptor->getRingingIndicationBristuff());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AllowCallerTransferDialOption', $dialOptionsDescriptor->getAllowCallerTransfer());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AllowCalleeTransferDialOption', $dialOptionsDescriptor->getAllowCalleeTransfer());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\ExecSubDialOption', $dialOptionsDescriptor->getExecSub());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomonDialOption', $dialOptionsDescriptor->getAllowCallerAutomon());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomonDialOption', $dialOptionsDescriptor->getAllowCalleeAutomon());        
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomixerDialOption', $dialOptionsDescriptor->getAllowCallerAutomixer());
        $this->assertInstanceOf('PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomixerDialOption', $dialOptionsDescriptor->getAllowCalleeAutomixer());        
    }

    public function testAllOptionsCanAssembleCorrectly()
    {
    	$serviceManager = Bootstrap::getServiceManager();    	 
    	$dialOptionsDescriptor = $serviceManager->get('PbxAgi\DialDescriptor\DialOptionsDescriptor');
        $dialOptionsDescriptor->getAnnouncement()->setFilename('test')->enable();
    	$dialOptionsDescriptor->getAllowCalledCallPark()->enable();
    	$dialOptionsDescriptor->getResetCdr()->enable();    	
    	$dialOptionsDescriptor->getAnsweredElseWhere()->enable();
    	$dialOptionsDescriptor->getPostConnectDtmf()->enable()->setDigits('12345');
    	$dialOptionsDescriptor->getFeatureWhileDialing()->enable();
    	$dialOptionsDescriptor->getCallHangupExtenOnPeer()->enable();    	
    	$dialOptionsDescriptor->getExecExtenAfterCallerHangup()
    						  ->enable()
    						  ->setContext('context')
    						  ->setExtension('extension')
    						  ->setPriority('priority')	
    							;
    	$dialOptionsDescriptor->getCallerIdBasedOnDialplanHint()->enable();
    	$dialOptionsDescriptor->getPostConnectDialPlanTransferBothTo()
    						  ->enable()
    						  ->setContext('context')
    						  ->setExtension('extension')
    						  ->setPriority('priority')
    						  ;
		$dialOptionsDescriptor->getJumpNextPriorityAfterConnect()->enable();
		$dialOptionsDescriptor->getCallerHangupStarKey()->enable();
		$dialOptionsDescriptor->getCalleeHangupStarKey()->enable();		
		$dialOptionsDescriptor->getIgnoreForwarding()->enable();			
		$dialOptionsDescriptor->getJumpToPriority()->enable();		
		$dialOptionsDescriptor->getAllowCallingCallPark()->enable();
		$dialOptionsDescriptor->getAllowCalledCallPark()->enable();		 		
		$dialOptionsDescriptor->getLimitCallWithWarning()
							  ->enable()
							  ->setLimitTime(600)
							  ->setWarningTime(300)	
							  ->setRepeatFreqency(100)
								; 
		$dialOptionsDescriptor->getExecuteMacro()
							  ->enable()
							  ->setMacroName('macro');		
		$dialOptionsDescriptor->getRingingMoh()
							  ->enable()
							  ->setMohClass('mohclass');
		$dialOptionsDescriptor->getDisableCallScreening()->enable();
		$dialOptionsDescriptor->getDeletePmIntroduction()
							  ->enable()
							  ->setDelete(1);
		$dialOptionsDescriptor->getRingBackDahdi()
							  ->enable()
							  ->setMode(2)
								;
		$dialOptionsDescriptor->getSendOriginalCallerId()->enable();
		$dialOptionsDescriptor->getPrivacyManager()
							  ->enable()
							  ->setDatabase('database')	
								;
		$dialOptionsDescriptor->getScreeningMode()->enable();		
		$dialOptionsDescriptor->getRingingIndicationBristuff()->enable();		
		$dialOptionsDescriptor->getRingingIndication()->enable();
		$dialOptionsDescriptor->getHangupAfter()
							  ->enable()
							  ->setTimeOut(20);		
		$dialOptionsDescriptor->getRingingIndication()->enable();
		$dialOptionsDescriptor->getRingingIndicationBristuff()->enable();
		$dialOptionsDescriptor->getAllowCallerTransfer()->enable();
		$dialOptionsDescriptor->getAllowCalleeTransfer()->enable();		
		$dialOptionsDescriptor->getExecSub()
							  ->enable()
							  ->setSubName('sub');		
		$dialOptionsDescriptor->getAllowCallerAutomon()->enable();		
		$dialOptionsDescriptor->getAllowCalleeAutomon()->enable();
		$dialOptionsDescriptor->getAllowCalleeAutomixer()->enable();
		$dialOptionsDescriptor->getAllowCallerAutomixer()->enable();	
		$this->assertEquals($dialOptionsDescriptor->__toString(), 'A(test)CcD(12345)deF(context^extension^priority)fG(context^extension^priority)gHhijKkL(600:300:100)M(macro)m(mohclass)Nn(1)O(2)oP(database)pRrS(20)TtU(sub)WwXx', "assembled options are not equal to the object''s content");	    	
    }
    public function testEmptyOptionsProduceEmptyResult()
    {
    	$serviceManager = Bootstrap::getServiceManager();
    	$dialOptionsDescriptor = $serviceManager->get('PbxAgi\DialDescriptor\DialOptionsDescriptor');
    	$this->assertEquals($dialOptionsDescriptor->__toString(), '', "options are not empty");    	 
    }
    public function testServiceLocatorGetterReturnsProperInstance()
    {
        $serviceManager = Bootstrap::getServiceManager();        
        $dialOptionsDescriptor = $serviceManager->get('PbxAgi\DialDescriptor\DialOptionsDescriptor');        
        $this->assertSame($serviceManager, $dialOptionsDescriptor->getServiceLocator());
    }
}
