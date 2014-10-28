<?php
namespace PbxAgi\Service\AppConfig;

use PbxAgi\GeneralSettings\Model\GeneralSettingsTable;
use PbxAgi\Service\VpbxidProvider\VpbxidProviderInterface;

interface AppConfigInterface
{
     const CONF_IS_PROTECTED_TRUE = 1;
     const CONF_IS_PROTECTED_FALSE = 0;
    
     const EXTENSION_NUMBER_LENGTH_LOCAL = 7;
     const EXTENSION_NUMBER_LENGTH_10_DIGITS = 10;
     const EXTENSION_NUMBER_LENGTH_11_DIGITS = 11;
    
     const DB_OPERATOR_PRESENCE_STATE_ABSENT = 'ABSENT';
     const DB_OPERATOR_PRESENCE_STATE_LOGGEDIN ='LOGGED_IN';
     const DB_OPERATOR_PRESENCE_STATE_SHORT_AWAY ='AWAY_SHORT';
     const DB_OPERATOR_PRESENCE_STATE_LUNCH_AWAY ='AWAY_LUNCH';
     
      
     const DB_CALLRECORDING_STATE_ACTIVE = 'active';
     const DB_CALLRECORDING_STATE_DISABLED = 'disabled';
      
    const DB_FEATURE_PERMISSION_UNDEFINED = 'undefined';
    const DB_FEATURE_PERMISSION_ALLOWED = 'allowed';
    const DB_FEATURE_PERMISSION_FORBIDDEN = 'barred';

    const DB_FAXSPOOL_RECORDTYPE_INCOMING = 'incoming';
    const DB_FAXSPOOL_RECORDTYPE_OUTGOING = 'outgoing';
    
    const DB_CALLSEQUENCE_RECORDTYPE_SEQUENTIAL = 'SEQUENTIAL';
    const DB_CALLSEQUENCE_RECORDTYPE_SIMULRING = 'SIMULRING';
    
    const DB_EXTENSION_STATUS_UNDEFINED = 'UNDEFINED';
    const DB_EXTENSION_STATUS_SUSPENDED = 'SUSPENDED';
    const DB_EXTENSION_STATUS_ACTIVE = 'ACTIVE';    
    
    const ASTERISK_APP_CONFBRIDGE_ADMINMODE = 'a';
    const ASTERISK_APP_CONFBRIDGE_ANNOUNCE_USERCOUNT = 'c';    
    const ASTERISK_APP_CONFBRIDGE_MUSICONHOLD_FIRSTENTRANT = 'M';
    
    const DB_INTERNAL_EXTENSIONTYPE_FAX = 'fax';
    
    const AST_TRANSFER_CONTEXT = 'transfer';
    
    const ASTERISK_STATUS_FAX_STATUS_SUCCESS = 'SUCCESS';
    
    const ASTERISK_STATUS_DIALSTATUS_NO_ANSWER = 'NOANSWER';
    
    const ASTERISK_STATUS_DIALSTATUS_BUSY = 'BUSY';

    const ASTERISK_STATUS_DIALSTATUS_CHANUNAVAIL = 'CHANUNAVAIL';
    
    const ASTERISK_STATUS_ANSWER = 'ANSWER';
    
    const ASTERISK_VM_DIVERSION_STATUS_ENABLED = 1;
    
    const ASTERISK_VM_DIVERSION_STATUS_DISABLED = 0;
        
    const AST_HANGUPCAUSE_OUTGOING_CALL_BARRED = 52;
    
    const VPBX_ID = 1;
    
    const ASTERISK_TRANSFER_CONTEXT_NAME = 'vpbx_transfer';
    
    const DB_PEER_TYPE_TRUNK = 'TRUNK';
    
    const ASTERISK_SKYPE_ALIAS_NUMBER_LENGTH = 4;
    
    const ASTERISK_DIALED_NUM_TYPE_EXTENSION = 'EXTENSION';
    
    const ASTERISK_DIALED_NUM_TYPE_PSTN = 'PSTN';
    
    const ASTERISK_DIALED_NUM_TYPE_SKYPE = 'SKYPE';

    const DB_DIVERSION_STATUS_UNDEFINED = 'UNDEFINED';
        
    const DB_DIVERSION_STATUS_ACTIVATED = 'ACTIVATED';    
    
    const DB_DIVERSION_STATUS_DEACTIVATED = 'DEACTIVATED';
    
    const DB_CONFERENCE_JOIN_ACL_INTERNALONLY = 'INTERNALONLY';
    
    
    function setGeneralSettingsTable(GeneralSettingsTable $generalSettingsTable);

    function setVpbxidProvider(VpbxidProviderInterface $vpbxidProvider);    
    
    function getSipExtensionContextName();
    
    function setSipExtensionContextName($sipExtensionContextName);
    
    function getMediareposDir();
    
    function setMediareposDir($mediareposDir);
    
    function getFileMoveCmd(); 

    function setFileMoveCmd($fileMoveCmd);

    function getTmpDir();
    
    function setTmpDir($tmpDir);

    function getPeerTechnology();

    function setPeerTechnology($peerTechnology);

    function getPauseAfterGreeting();
   
    function setPauseAfterGreeting($pauseAfterGreeting);

    function getDigitsAbortGreeting();
   
    function setDigitsAbortGreeting($digitsAbortGreeting);
 
    function getSilenceFile();

    function setSilenceFile($silenceFile);

    function getExtensionLength();

    function setExtensionLength($extensionLength);

    function getGreetingWaitBetweenDigits();
    
    function setGreetingWaitBetweenDigits($greetingWaitBetweenDigits);

    function getCallRecordFileExtension();

    function setCallRecordFileExtension($callRecordFileExtension);

    function getPostRecordCommand();

    function setPostRecordCommand($postRecordCommand);

    function getRecordCallMacroName();
    
    function setRecordCallMacroName($recordCallMacroName);

    function getDialSipExtensionContextName();

    function setDialSipExtensionContextName($dialSipExtensionContextName);

    function getBusinessHoursGreeting();
    
    function getOffTimeGreeting();

    function setOffTimeGreeting($offTimeGreeting);

    function getInvalidNumberDialedMessage();
    
    function setInvalidNumberDialedMessage($invalidNumberDialedMessage);

    function getRecordcallPostCmd();
    
    function setRecordcallPostCmd($recordcallPostCmd);

    function getCallCentreContextName();
    
    function setCallCentreContextName($callCentreContextName);
   
    function getIncomingPstnMenuInputTotalMax();
    
    function setIncomingPstnMenuInputTotalMax($incomingPstnMenuInputTotalMax);

    function getIncomingPstnMenuInputBetweenDigitsMax();
    
    function setIncomingPstnMenuInputBetweenDigitsMax($incomingPstnMenuInputBetweenDigitsMax) ;
    
    function getExtensionSipReceiveIncomingContextName();

    function setExtensionSipReceiveIncomingContextName($extensionSipReceiveIncomingContextName);

    
    function getDialCallCentreOperatorDuration();

    function setDialCallCentreOperatorDuration($dialCallCentreOperatorDuration);
   
    function getCallForwardNumCombination();

    function setCallForwardNumCombination($callForwardNumCombination);
    
    function getVpbxDialoutContextName();
    
    function setVpbxDialoutContextName($vpbxDialoutContextName);
    
    function getOperatorChangeStatusLunchbreakMedia();

    function setOperatorChangeStatusLunchbreakMedia($operatorChangeStatusLunchbreakMedia);

    function getOperatorChangeStatusShortbreakMedia();

    function setOperatorChangeStatusShortbreakMedia($operatorChangeStatusShortbreakMedia);

    function getOperatorChangeStatusLogoutMedia();

    function setOperatorChangeStatusLogoutMedia($operatorChangeStatusLogoutMedia);

    function getOperatorChangeStatusIncorrectChoiceMedia();

    function setOperatorChangeStatusIncorrectChoiceMedia($operatorChangeStatusIncorrectChoiceMedia);

    function getOperatorChangeStatusLoginMedia();

    function setOperatorChangeStatusLoginMedia($operatorChangeStatusLoginMedia);
    
    function getCallForwardMediaDiversionCleared();
    
    function getCallForwardMediaDiversionAlreadyset();
    
    function getCallForwardMediaDiversionNumNotice();

    function getCallForwardMediaDiversionPure();
    
    function getCallForwardMediaDiversionReenabledNumNotice();
    
    function getCallForwardMediaDiversionHasBeenSetup();
    
    function setCallForwardMediaDiversionCleared($callForwardMediaDiversionCleared);
    
    function setCallForwardMediaDiversionAlreadyset($callForwardMediaDiversionAlreadyset);
    
    function setCallForwardMediaDiversionNumNotice($callForwardMediaDiversionNumNotice);
    
    function setCallForwardMediaDiversionPure($callForwardMediaDiversionPure);
    
    function setCallForwardMediaDiversionReenabledNumNotice($callForwardMediaDiversionReenabledNumNotice);
    
    function setCallForwardMediaDiversionHasBeenSetup($callForwardMediaDiversionHasBeenSetup);

    function getFaxReceiveSpoolDir();
    
    function setFaxReceiveSpoolDir($faxReceiveSpoolDir);
    
    function getFaxReceiveOptions();
    
    function setFaxReceiveOptions($faxReceiveOptions);
    
    function getFaxReceiveNumTries();
     
    function setFaxReceiveNumTries($faxReceiveNumTries);
    
    function getFaxReceiveMessageFromAddress();
    
    function getFaxReceiveMessageFromFullname();
    
    function setFaxReceiveMessageFromAddress($faxReceiveMessageFromAddress);
    
    function setFaxReceiveMessageFromFullname($faxReceiveMessageFromFullname);
    
    function getConferencePasswordPrompt();
    
    function setConferencePasswordPrompt($conferencePasswordPrompt);
             
    function getConferenceEnterNumPrompt();
    
    function getConferenceConfNumInvalid();
    
    function getConferenceConfPasswordInvalid();
    
    function setConferenceEnterNumPrompt($conferenceEnterNumPrompt);    

    function setConferenceConfNumInvalid($conferenceConfNumInvalid);
    
    function setConferenceConfPasswordInvalid($conferenceConfPasswordInvalid);
        
    function getShortDialNumCreateInvalidOrAlreadyExists();
    
    function setShortDialNumCreateInvalidOrAlreadyExists($shortDialNumCreateInvalidOrAlreadyExists);
    
    function getShortDialCurrentNumDoesntExists();
    
    function setShortDialCurrentNumDoesntExists($shortDialCurrentNumDoesntExists);
    
    function getShortDialListIsEmpty();
    
    function setShortDialListIsEmpty($shortDialListIsEmpty);
    
    function getShortDialListFirstItemReached();
    
    function getShortDialListLastItemReached();
    
    function setShortDialListFirstItemReached($shortDialListFirstItemReached);
    
    function setShortDialListLastItemReached($shortDialListLastItemReached);
    
    function getShortSaveShortIs();
    
    function getShortSaveNumberIs();
        
    function setShortSaveShortIs($shortSaveShortIs);
    
    function setShortSaveNumberIs($shortSaveNumberIs);       
    
    function getShortDialItemDeleted();     
    
    function setShortDialItemDeleted($shortDialItemDeleted);   

    function getShortDialMainMenuPrompt();
    
    function setShortDialMainMenuPrompt($shortDialMainMenuPrompt);    
    
    function getShortDialIndexMenuPrompt();
    
    function setShortDialIndexMenuPrompt($shortDialIndexMenuPrompt);
    
    function getShortDialEnterShort();
    
    function setShortDialEnterShort($shortDialEnterShort);
    
    function getShortDialItemDeleteConfirm();
    
    function setShortDialItemDeleteConfirm($shortDialItemDeleteConfirm);    
    
    function getShortDialEnterSnumGoto();
    
    function setShortDialEnterSnumGoto($shortDialEnterSnumGoto);
    
    function getShortDialShortDoesntExists();
    
    function setShortDialShortDoesntExists($shortDialShortDoesntExists);
    
    function getShortDialNumDstInvalid();
    
    function setShortDialNumDstInvalid($shortDialNumDstInvalid);
       
     
    function getGeneralSettings();
            
    function getIncomingPstnMenuInputTotalMaxOfftime();
    
    function setIncomingPstnMenuInputTotalMaxOfftime($incomingPstnMenuInputTotalMaxOfftime);
 
    function setSimulringMaxCallingDuration($simulringMaxCallingDuration);
     
    function getSimulringMaxCallingDuration();
    
    function getOriginatorIsBlockedMedia();
    
    function setOriginatorIsBlockedMedia($orignatorIsBlockedMedia);

    function getIvrContextName();
    
    function getFeaturesContextName(); 
    
    function setFeaturesContextName($featuresContextName);
    
    function getConferenceEnterPstnDisallowedNotice();
    
    function setConferenceEnterPstnDisallowedNotice($conferenceEnterPstnDisallowedNotice);

    function getNumberIsBlockedMedia();
    
    function setNumberIsBlockedMedia($numberIsBlockedMedia);

    function getShortDialCreateMenuPrompt();
   
    function setShortDialCreateMenuPrompt($shortDialCreateMenuPrompt);
    
    function getEmailfaxBounceUnknownUserSubject();
    
    function setEmailfaxBounceUnknownUserSubject($emailfaxBounceUnknownUserSubject);
    
    function getAsteriskCallfileSpoolPath();
   
    function setAsteriskCallfileSpoolPath($asteriskCallfileSpoolPath);	
    
    function getFaxsenderContextName();
    
    function setFaxsenderContextName($faxsenderContextName);

    function getFaxdialerContextName();
    
    function setFaxdialerContextName($faxdialerContextName);
    
    function getFaxSendMaxTries();
     
    function setFaxSendMaxTries($faxSendMaxTries);
    
    function getFaxSendWaitTime();
    
    function setFaxSendWaitTime($faxSendWaitTime);
    
    function getFaxSpoolPath();
    
    function setFaxSpoolPath($faxSpoolPath);

    function getGhostscriptBinaryPath();
      
    function setGhostscriptBinaryPath($ghostscriptBinaryPath);
    
    function getConferenceSelectScopePrompt();
    
    function setConferenceSelectScopePrompt($conferenceSelectScopePrompt);    
    
    function getFunctionDisabledNotice();
    
    function setFunctionDisabledNotice($functionDisabledNotice);
    
    function getMohInternalState();
    
    function setBusinessHoursGreeting($businessHoursGreeting);
    
    function setMohInternalState($mohInternalState);

    function getAlarmWrongTimeFormat();
     
    function setAlarmWrongTimeFormat($alarmWrongTimeFormat);
    
    function getAlarmPlayContextName();
    
    function setAlarmPlayContextName($alarmPlayContextName);
     
}
    