<?php
namespace PbxAgi\Service\ChannelVarManager;

use PbxAgi\Entity\CallEntityInterface;

interface ChannelVarManagerInterface
{
    const CHANNEL_NUMBER_PARSER_PATTERN = '/^(\w+)\/(\w+)-(\w+)$/';
    
    const CHANNEL_NUMBER_PARSER_PATTERN_LOCAL_CHANNEL = '/^(Local)\/(\w+)@(\w+)-(\w+);(\w+)$/';
    
    const CH_LANGUAGE_TYPE_RU = 'ru';
    
    function setupOutgoingCall(\PbxAgi\Entity\CallEntityInterface $call);
    function setupIncomingCallPstn(CallEntityInterface $call=null);
    function setupIncomingCallCallCentre(CallEntityInterface $call);
    function setDialoutaction($action);
    function getExten();    
    function getUnqieId();
    function getFaxStatus();
    function getCallerId();
    function getCallerTransferPermission();
    function getCalleeTransferPermission();
	function setCallerTransferPermission($callerTransferPermission); 	
	function setCalleeTransferPermission($calleeTransferPermission);         
	function setLanguage($language);
    function voiceMail($mailbox);
    function initTransferContext();
    function setCallIsTransfered();    
    function isTransfered();
    function setupRecordFilename();    
    function setRecordingForbidden();
    function isRecordingForbidden();
}