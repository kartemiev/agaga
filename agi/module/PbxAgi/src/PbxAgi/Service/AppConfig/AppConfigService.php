<?php
namespace PbxAgi\Service\AppConfig;

use PbxAgi\Service\AppConfig\AppConfigInterface;
use Zend\Stdlib\AbstractOptions;
use PbxAgi\GeneralSettings\Model\GeneralSettingsTable;
use PbxAgi\Service\VpbxidProvider\VpbxidProviderInterface;

class AppConfigService extends AbstractOptions implements AppConfigInterface
{
    const DIALOPTION_IGNORE_FORWARD_ATTEMPTS = 'i';
    const DIALOPTION_ALLOW_CALLEE_CALLPARK = 'k';
    const DIALOPTION_EXECUTE_MACRO_ON_CALLING_CHANNEL = 'M(%s)';
    const DIALOPTION_PLAY_MOH_WHILE_CONNECTING = 'm';
    const DIALOPTION_ALLOW_CALLEE_TRANSFER = 't';    
    const DIALOPTION_ALLOW_CALLER_CALLPARK = 'K';
    
   const DIALOPTION_ALLOW_CALLER_TRANSFER = 'T';
   const DIALOPTION_ALLOW_CALLER_STARTMON = 'W';
   const DIALOPTION_RINGBACKTONE_CLASS = 'm(%s)';
   const RINGBACK_MOH_CLASS = '1_ringingtone';
   
              
    protected $mediareposDir;
    protected $fileMoveCmd;
    protected $tmpDir;
    protected $peerTechnology;
    protected $pauseAfterGreeting;
    protected $digitsAbortGreeting;
    protected $silenceFile;
    protected $extensionLength;
    protected $greetingWaitBetweenDigits;
    protected $callRecordFileExtension;
    protected $postRecordCommand;
    protected $recordCallMacroName;
    protected $dialSipExtensionContextName;
    protected $businessHoursGreeting;
    protected $offTimeGreeting;
    protected $invalidNumberDialedMessage;
     protected $recordcallPostCmd;
    protected $callCentreContextName;
    protected $sipExtensionContextName;
    protected $incomingPstnMenuInputTotalMax;
    protected $incomingPstnMenuInputBetweenDigitsMax;
    protected $extensionSipReceiveIncomingContextName;
    protected $dialCallCentreOperatorDuration;
    protected $callForwardNumCombination;
    protected $vpbxDialoutContextName;
    
    protected $operatorChangeStatusLunchbreakMedia;    
    protected $operatorChangeStatusShortbreakMedia;    
    protected $operatorChangeStatusLogoutMedia;    
    protected $operatorChangeStatusIncorrectChoiceMedia;        
    protected $operatorChangeStatusLoginMedia;
    
    protected $callForwardMediaDiversionCleared;
    protected $callForwardMediaDiversionAlreadyset;
    protected $callForwardMediaDiversionNumNotice;
    protected $callForwardMediaDiversionPure;
    protected $callForwardMediaDiversionReenabledNumNotice;
    protected $callForwardMediaDiversionHasBeenSetup;
    protected $faxReceiveSpoolDir;
    protected $faxReceiveOptions;
    protected $faxReceiveNumTries;
    protected $faxReceiveMessageFromAddress;
    protected $faxReceiveMessageFromFullname;
    protected $faxReceiveMessageTo;
    protected $conferencePasswordPrompt;
    protected $conferenceEnterNumPrompt;
    protected $conferenceConfNumInvalid;    
    protected $conferenceConfPasswordInvalid;
    protected $conferenceEnterPstnDisallowedNotice;
    protected $shortDialNumCreateInvalidOrAlreadyExists;
    protected $shortDialCurrentNumDoesntExists;
    protected $shortDialListIsEmpty;    
    protected $shortDialListFirstItemReached;
    protected $shortDialListLastItemReached;    
    protected $shortSaveShortIs;
    protected $shortSaveNumberIs;
    protected $shortDialItemDeleted;    
    protected $shortDialMainMenuPrompt;    
    protected $shortDialIndexMenuPrompt;
    protected $shortDialEnterShort;    
    protected $shortDialItemDeleteConfirm;
    protected $shortDialEnterSnumGoto;    
    protected $shortDialShortDoesntExists;
    protected $shortDialNumDstInvalid;    
     protected $incomingPstnMenuInputTotalMaxOfftime;
    protected $simulringMaxCallingDuration;
    protected $originatorIsBlockedMedia;
    protected $ivrContextName;
    protected $featuresContextName;
    protected $numberIsBlockedMedia;
    protected $shortDialCreateMenuPrompt;
    protected $generalSettings;
    protected $emailfaxBounceUnknownUserSubject;    
    protected $asteriskCallfileSpoolPath;
    protected $faxsenderContextName;
    protected $faxdialerContextName;    
    protected $faxSendMaxTries;
    protected $faxSendWaitTime;
    protected $faxSpoolPath;
	protected $functionDisabledNotice;
    protected $ghostscriptBinaryPath;
    protected $mohInternalState;
    protected $conferenceSelectScopePrompt;
    
    protected $alarmWrongTimeFormat;
    protected $alarmPlayContextName;
    protected $vpbxidProvider;
     /**
	 * @return the $functionDisabledNotice
	 */
    
    protected $generalSettingsTable;
    
    public function setGeneralSettingsTable(GeneralSettingsTable $generalSettingsTable)
    {
        $this->generalSettingsTable = $generalSettingsTable;
        return $this;
    }
    public function setVpbxidProvider(VpbxidProviderInterface $vpbxidProvider)
    {
        $this->vpbxidProvider = $vpbxidProvider;
        return $this;  
    }
    
	public function getFunctionDisabledNotice() {
		return $this->functionDisabledNotice;
	}

	/**
	 * @param field_type $functionDisabledNotice
	 */
	public function setFunctionDisabledNotice($functionDisabledNotice) {
		$this->functionDisabledNotice = $functionDisabledNotice;
	}

	public function getOperatorChangeStatusLunchbreakMedia() {
        return $this->operatorChangeStatusLunchbreakMedia;
    }

    public function setOperatorChangeStatusLunchbreakMedia($operatorChangeStatusLunchbreakMedia) {
        $this->operatorChangeStatusLunchbreakMedia = $operatorChangeStatusLunchbreakMedia;
    }

    public function getOperatorChangeStatusShortbreakMedia() {
        return $this->operatorChangeStatusShortbreakMedia;
    }

    public function setOperatorChangeStatusShortbreakMedia($operatorChangeStatusShortbreakMedia) {
        $this->operatorChangeStatusShortbreakMedia = $operatorChangeStatusShortbreakMedia;
    }

    public function getOperatorChangeStatusLogoutMedia() {
        return $this->operatorChangeStatusLogoutMedia;
    }

    public function setOperatorChangeStatusLogoutMedia($operatorChangeStatusLogoutMedia) {
        $this->operatorChangeStatusLogoutMedia = $operatorChangeStatusLogoutMedia;
    }

    public function getOperatorChangeStatusIncorrectChoiceMedia() {
        return $this->operatorChangeStatusIncorrectChoiceMedia;
    }

    public function setOperatorChangeStatusIncorrectChoiceMedia($operatorChangeStatusIncorrectChoiceMedia) {
        $this->operatorChangeStatusIncorrectChoiceMedia = $operatorChangeStatusIncorrectChoiceMedia;
    }

    public function getOperatorChangeStatusLoginMedia() {
        return $this->operatorChangeStatusLoginMedia;
    }

    public function setOperatorChangeStatusLoginMedia($operatorChangeStatusLoginMedia) {
        $this->operatorChangeStatusLoginMedia = $operatorChangeStatusLoginMedia;
    }

    
    public function getVpbxDialoutContextName() {
        return $this->vpbxDialoutContextName;
    }

    public function setVpbxDialoutContextName($vpbxDialoutContextName) {
        $this->vpbxDialoutContextName = $vpbxDialoutContextName;
        return $this;
    }

        public function getCallForwardNumCombination() {
        return $this->callForwardNumCombination;
    }

    public function setCallForwardNumCombination($callForwardNumCombination) {
        $this->callForwardNumCombination = $callForwardNumCombination;
        return $this;
    }

         
        public function getDialCallCentreOperatorDuration() {
        return $this->dialCallCentreOperatorDuration;
    }

    public function setDialCallCentreOperatorDuration($dialCallCentreOperatorDuration) {
        $this->dialCallCentreOperatorDuration = $dialCallCentreOperatorDuration;
        return $this;
    }

    
    public function getExtensionSipReceiveIncomingContextName() {
        return $this->extensionSipReceiveIncomingContextName;
    }

    public function setExtensionSipReceiveIncomingContextName($extensionSipReceiveIncomingContextName) {
        $this->extensionSipReceiveIncomingContextName = $extensionSipReceiveIncomingContextName;
        return $this;
    }

        

    public function getIncomingPstnMenuInputTotalMax() {       
        return $this->incomingPstnMenuInputTotalMax;
    }

    public function setIncomingPstnMenuInputTotalMax($incomingPstnMenuInputTotalMax) {
        $this->incomingPstnMenuInputTotalMax = $incomingPstnMenuInputTotalMax;
        return $this;
    }

    public function getIncomingPstnMenuInputBetweenDigitsMax() {
        return $this->incomingPstnMenuInputBetweenDigitsMax;
    }

    public function setIncomingPstnMenuInputBetweenDigitsMax($incomingPstnMenuInputBetweenDigitsMax) {
        $this->incomingPstnMenuInputBetweenDigitsMax = $incomingPstnMenuInputBetweenDigitsMax;
        return $this;
    }

            public function getSipExtensionContextName() {
        return $this->sipExtensionContextName;
    }

    public function setSipExtensionContextName($sipExtensionContextName) {
        $this->sipExtensionContextName = $sipExtensionContextName;
        return $this;
    }

        public function getMediareposDir() {
        return $this->mediareposDir;
    }

    public function setMediareposDir($mediareposDir) {
        $this->mediareposDir = $mediareposDir;
        return $this;
    }

    public function getFileMoveCmd() {
        return $this->fileMoveCmd;
    }

    public function setFileMoveCmd($fileMoveCmd) {
        $this->fileMoveCmd = $fileMoveCmd;
        return $this;
    }

    public function getTmpDir() {
        return $this->tmpDir;
    }

    public function setTmpDir($tmpDir) {
        $this->tmpDir = $tmpDir;
        return $this;
    }

    public function getPeerTechnology() {
        return $this->peerTechnology;
    }

    public function setPeerTechnology($peerTechnology) {
        $this->peerTechnology = $peerTechnology;
        return $this;
    }

    public function getPauseAfterGreeting() {
        return $this->pauseAfterGreeting;
    }

    public function setPauseAfterGreeting($pauseAfterGreeting) {
        $this->pauseAfterGreeting = $pauseAfterGreeting;
        return $this;
    }

    public function getDigitsAbortGreeting() {
        return $this->digitsAbortGreeting;
    }

    public function setDigitsAbortGreeting($digitsAbortGreeting) {
        $this->digitsAbortGreeting = $digitsAbortGreeting;
        return $this;
    }

    public function getSilenceFile() {
        return $this->silenceFile;
    }

    public function setSilenceFile($silenceFile) {
        $this->silenceFile = $silenceFile;
        return $this;
    }

    public function getExtensionLength() {
        return $this->extensionLength;
    }

    public function setExtensionLength($extensionLength) {
        $this->extensionLength = $extensionLength;
        return $this;
    }

    public function getGreetingWaitBetweenDigits() {
        return $this->greetingWaitBetweenDigits;
    }

    public function setGreetingWaitBetweenDigits($greetingWaitBetweenDigits) {
        $this->greetingWaitBetweenDigits = $greetingWaitBetweenDigits;
        return $this;
    }

    public function getCallRecordFileExtension() {
        return $this->callRecordFileExtension;
    }

    public function setCallRecordFileExtension($callRecordFileExtension) {
        $this->callRecordFileExtension = $callRecordFileExtension;
        return $this;
    }

    public function getPostRecordCommand() {
        return $this->postRecordCommand;
    }

    public function setPostRecordCommand($postRecordCommand) {
        $this->postRecordCommand = $postRecordCommand;
        return $this;
    }

    public function getRecordCallMacroName() {
        return $this->recordCallMacroName;
    }

    public function setRecordCallMacroName($recordCallMacroName) {
        $this->recordCallMacroName = $recordCallMacroName;
        return $this;
    }

    public function getDialSipExtensionContextName() {
        return $this->dialSipExtensionContextName;
    }

    public function setDialSipExtensionContextName($dialSipExtensionContextName) {
        $this->dialSipExtensionContextName = $dialSipExtensionContextName;
        return $this;
    }

    public function getBusinessHoursGreeting() {
        if (!$this->businessHoursGreeting)
        {
            $generalSettings = $this->getGeneralSettings();        
            $mediaReposPath = $generalSettings->mediarepospath;
            $id = $generalSettings->greeting;
            $mediaFileName = "{$mediaReposPath}/{$id}/{$id}"; 
            $this->businessHoursGreeting =  $mediaFileName;
        }
        return $this->businessHoursGreeting;
    }
     public function setBusinessHoursGreeting($businessHoursGreeting) {
        $this->businessHoursGreeting = $businessHoursGreeting;
        return $this;
    }

    public function getOffTimeGreeting() {
        if (!isset($this->offTimeGreeting))
        {
             $generalSettings = $this->getGeneralSettings();        
            $mediaReposPath = $generalSettings->mediarepospath;
            $id = $generalSettings->greetingofftime;
            $mediaFileName = "{$mediaReposPath}/{$id}/{$id}"; 
            $this->offTimeGreeting = $mediaFileName;
        }
        return $this->offTimeGreeting;
    }

    public function setOffTimeGreeting($offTimeGreeting) {
        $this->offTimeGreeting = $offTimeGreeting;
        return $this;
    }

    public function getInvalidNumberDialedMessage() {
        return $this->invalidNumberDialedMessage;
    }

    public function setInvalidNumberDialedMessage($invalidNumberDialedMessage) {
        $this->invalidNumberDialedMessage = $invalidNumberDialedMessage;
        return $this;
    }

    public function getRecordcallPostCmd() {
        return $this->recordcallPostCmd;
    }

    public function setRecordcallPostCmd($recordcallPostCmd) {
        $this->recordcallPostCmd = $recordcallPostCmd;
        return $this;
    }

    public function getCallCentreContextName() {
        return $this->callCentreContextName;
    }

    public function setCallCentreContextName($callCentreContextName) {
        $this->callCentreContextName = $callCentreContextName;
        return $this;
    }

  
 	/**
     * @return the $callForwardMediaDiversionCleared
     */
    public function getCallForwardMediaDiversionCleared()
    {
        return $this->callForwardMediaDiversionCleared;
    }

	/**
     * @return the $callForwardMediaDiversionAlreadyset
     */
    public function getCallForwardMediaDiversionAlreadyset()
    {
        return $this->callForwardMediaDiversionAlreadyset;
    }

	/**
     * @return the $callForwardMediaDiversionNumNotice
     */
    public function getCallForwardMediaDiversionNumNotice()
    {
        return $this->callForwardMediaDiversionNumNotice;
    }

	/**
     * @return the $callForwardMediaDiversionPure
     */
    public function getCallForwardMediaDiversionPure()
    {
        return $this->callForwardMediaDiversionPure;
    }

	/**
     * @return the $callForwardMediaDiversionReenabledNumNotice
     */
    public function getCallForwardMediaDiversionReenabledNumNotice()
    {
        return $this->callForwardMediaDiversionReenabledNumNotice;
    }

	/**
     * @return the $callForwardMediaDiversionHasBeenSetup
     */
    public function getCallForwardMediaDiversionHasBeenSetup()
    {
        return $this->callForwardMediaDiversionHasBeenSetup;
    }

	/**
     * @param field_type $callForwardMediaDiversionCleared
     */
    public function setCallForwardMediaDiversionCleared($callForwardMediaDiversionCleared)
    {
        $this->callForwardMediaDiversionCleared = $callForwardMediaDiversionCleared;
    }

	/**
     * @param field_type $callForwardMediaDiversionAlreadyset
     */
    public function setCallForwardMediaDiversionAlreadyset($callForwardMediaDiversionAlreadyset)
    {
        $this->callForwardMediaDiversionAlreadyset = $callForwardMediaDiversionAlreadyset;
    }

	/**
     * @param field_type $callForwardMediaDiversionNumNotice
     */
    public function setCallForwardMediaDiversionNumNotice($callForwardMediaDiversionNumNotice)
    {
        $this->callForwardMediaDiversionNumNotice = $callForwardMediaDiversionNumNotice;
    }

	/**
     * @param field_type $callForwardMediaDiversionPure
     */
    public function setCallForwardMediaDiversionPure($callForwardMediaDiversionPure)
    {
        $this->callForwardMediaDiversionPure = $callForwardMediaDiversionPure;
    }

	/**
     * @param field_type $callForwardMediaDiversionReenabledNumNotice
     */
    public function setCallForwardMediaDiversionReenabledNumNotice($callForwardMediaDiversionReenabledNumNotice)
    {
        $this->callForwardMediaDiversionReenabledNumNotice = $callForwardMediaDiversionReenabledNumNotice;
    }

	/**
     * @param field_type $callForwardMediaDiversionHasBeenSetup
     */
    public function setCallForwardMediaDiversionHasBeenSetup($callForwardMediaDiversionHasBeenSetup)
    {
        $this->callForwardMediaDiversionHasBeenSetup = $callForwardMediaDiversionHasBeenSetup;
    }
	public function getFaxReceiveSpoolDir()
    {
        return $this->faxReceiveSpoolDir;
    }

	public function setFaxReceiveSpoolDir($faxReceiveSpoolDir)
    {
        $this->faxReceiveSpoolDir = $faxReceiveSpoolDir;
    }
	public function getFaxReceiveOptions()
    {
        return $this->faxReceiveOptions;
    }

	public function setFaxReceiveOptions($faxReceiveOptions)
    {
        $this->faxReceiveOptions = $faxReceiveOptions;
    }
	public function getFaxReceiveNumTries()
    {
        return $this->faxReceiveNumTries;
    }

	public function setFaxReceiveNumTries($faxReceiveNumTries)
    {
        $this->faxReceiveNumTries = $faxReceiveNumTries;
    }
	public function getFaxReceiveMessageFromAddress()
    {
        return $this->faxReceiveMessageFromAddress;
    }

	public function getFaxReceiveMessageFromFullname()
    {
        return $this->faxReceiveMessageFromFullname;
    }

	public function setFaxReceiveMessageFromAddress($faxReceiveMessageFromAddress)
    {
        $this->faxReceiveMessageFromAddress = $faxReceiveMessageFromAddress;
    }

	public function setFaxReceiveMessageFromFullname($faxReceiveMessageFromFullname)
    {
        $this->faxReceiveMessageFromFullname = $faxReceiveMessageFromFullname;
    }
	public function getFaxReceiveMessageTo()
    {
        return $this->faxReceiveMessageTo;
    }

	public function setFaxReceiveMessageTo($faxReceiveMessageTo)
    {
        $this->faxReceiveMessageTo = $faxReceiveMessageTo;
    }
	public function getConferencePasswordPrompt()
    {
        return $this->conferencePasswordPrompt;
    }

	public function setConferencePasswordPrompt($conferencePasswordPrompt)
    {
        $this->conferencePasswordPrompt = $conferencePasswordPrompt;
    }
	public function getConferenceEnterNumPrompt()
    {
        return $this->conferenceEnterNumPrompt;
    }

	public function getConferenceConfNumInvalid()
    {
        return $this->conferenceConfNumInvalid;
    }

	public function getConferenceConfPasswordInvalid()
    {
        return $this->conferenceConfPasswordInvalid;
    }

	public function setConferenceEnterNumPrompt($conferenceEnterNumPrompt)
    {
        $this->conferenceEnterNumPrompt = $conferenceEnterNumPrompt;
    }

	public function setConferenceConfNumInvalid($conferenceConfNumInvalid)
    {
        $this->conferenceConfNumInvalid = $conferenceConfNumInvalid;
    }

	public function setConferenceConfPasswordInvalid($conferenceConfPasswordInvalid)
    {
        $this->conferenceConfPasswordInvalid = $conferenceConfPasswordInvalid;
    }
	public function getShortDialNumCreateInvalidOrAlreadyExists()
    {
        return $this->shortDialNumCreateInvalidOrAlreadyExists;
    }

	public function setShortDialNumCreateInvalidOrAlreadyExists($shortDialNumCreateInvalidOrAlreadyExists)
    {
        $this->shortDialNumCreateInvalidOrAlreadyExists = $shortDialNumCreateInvalidOrAlreadyExists;
    }
	public function getShortDialCurrentNumDoesntExists()
    {
        return $this->shortDialCurrentNumDoesntExists;
    }

	public function setShortDialCurrentNumDoesntExists($shortDialCurrentNumDoesntExists)
    {
        $this->shortDialCurrentNumDoesntExists = $shortDialCurrentNumDoesntExists;
    }
	public function getShortDialListIsEmpty()
    {
        return $this->shortDialListIsEmpty;
    }

	public function setShortDialListIsEmpty($shortDialListIsEmpty)
    {
        $this->shortDialListIsEmpty = $shortDialListIsEmpty;
    }
	public function getShortDialListFirstItemReached()
    {
        return $this->shortDialListFirstItemReached;
    }

	public function getShortDialListLastItemReached()
    {
        return $this->shortDialListLastItemReached;
    }

	public function setShortDialListFirstItemReached($shortDialListFirstItemReached)
    {
        $this->shortDialListFirstItemReached = $shortDialListFirstItemReached;
    }

	public function setShortDialListLastItemReached($shortDialListLastItemReached)
    {
        $this->shortDialListLastItemReached = $shortDialListLastItemReached;
    }
	public function getShortSaveShortIs()
    {
        return $this->shortSaveShortIs;
    }

	public function getShortSaveNumberIs()
    {
        return $this->shortSaveNumberIs;
    }

	public function setShortSaveShortIs($shortSaveShortIs)
    {
        $this->shortSaveShortIs = $shortSaveShortIs;
    }

	public function setShortSaveNumberIs($shortSaveNumberIs)
    {
        $this->shortSaveNumberIs = $shortSaveNumberIs;
    }
	public function getShortDialItemDeleted()
    {
        return $this->shortDialItemDeleted;
    }

	public function setShortDialItemDeleted($shortDialItemDeleted)
    {
        $this->shortDialItemDeleted = $shortDialItemDeleted;
    }
	public function getShortDialMainMenuPrompt()
    {
        return $this->shortDialMainMenuPrompt;
    }

	public function setShortDialMainMenuPrompt($shortDialMainMenuPrompt)
    {
        $this->shortDialMainMenuPrompt = $shortDialMainMenuPrompt;
    }
	public function getShortDialIndexMenuPrompt()
    {
        return $this->shortDialIndexMenuPrompt;
    }

	public function setShortDialIndexMenuPrompt($shortDialIndexMenuPrompt)
    {
        $this->shortDialIndexMenuPrompt = $shortDialIndexMenuPrompt;
    }
	public function getShortDialEnterShort()
    {
        return $this->shortDialEnterShort;
    }

	public function setShortDialEnterShort($shortDialEnterShort)
    {
        $this->shortDialEnterShort = $shortDialEnterShort;
    }
	public function getShortDialItemDeleteConfirm()
    {
        return $this->shortDialItemDeleteConfirm;
    }

	public function setShortDialItemDeleteConfirm($shortDialItemDeleteConfirm)
    {
        $this->shortDialItemDeleteConfirm = $shortDialItemDeleteConfirm;
    }
	public function getShortDialEnterSnumGoto()
    {
        return $this->shortDialEnterSnumGoto;
    }

	public function setShortDialEnterSnumGoto($shortDialEnterSnumGoto)
    {
        $this->shortDialEnterSnumGoto = $shortDialEnterSnumGoto;
    }
	public function getShortDialShortDoesntExists()
    {
        return $this->shortDialShortDoesntExists;
    }

	public function setShortDialShortDoesntExists($shortDialShortDoesntExists)
    {
        $this->shortDialShortDoesntExists = $shortDialShortDoesntExists;
    }
	public function getShortDialNumDstInvalid()
    {
        return $this->shortDialNumDstInvalid;
    }

	public function setShortDialNumDstInvalid($shortDialNumDstInvalid)
    {
        $this->shortDialNumDstInvalid = $shortDialNumDstInvalid;
    }
   
  	public function getGeneralSettings()
    {
        if (!isset($this->generalSettings))
        {
            $this->generalSettings = $this->generalSettingsTable->getSettings($this->vpbxidProvider->getVpbxId());
        }
        return $this->generalSettings;
    }

	public function getIncomingPstnMenuInputTotalMaxOfftime()
    {
        if (!isset($this->incomingPstnMenuInputTotalMaxOfftime))
        {
        	$this->incomingPstnMenuInputTotalMaxOfftime = $this->getGeneralSettings()->vmtimeout*1000;
        }
        return $this->incomingPstnMenuInputTotalMaxOfftime;
    }

	public function setIncomingPstnMenuInputTotalMaxOfftime($incomingPstnMenuInputTotalMaxOfftime)
    {
        $this->incomingPstnMenuInputTotalMaxOfftime = $incomingPstnMenuInputTotalMaxOfftime;
    }
 
    public function setSimulringMaxCallingDuration($simulringMaxCallingDuration)
    {
        $this->simulringMaxCallingDuration = $simulringMaxCallingDuration;
        return $this;
    }
    public function getSimulringMaxCallingDuration()
    {
        return $this->simulringMaxCallingDuration;
    }
 
    public function getOriginatorIsBlockedMedia()
    {
        return $this->originatorIsBlockedMedia;
    }
    public function setOriginatorIsBlockedMedia($orginatorIsBlockedMedia)
    {
        $this->originatorIsBlockedMedia = $orginatorIsBlockedMedia;
        return $this;
    }
    public function setIvrContextName($ivrContextName)
    {
        $this->ivrContextName = $ivrContextName;
        return $this;
    }
    public function getIvrContextName()
    {
        return $this->ivrContextName;
    }
    
    public function getFeaturesContextName()
    {
        return $this->featuresContextName;
    }
    public function setFeaturesContextName($featuresContextName)
    {
        $this->featuresContextName = $featuresContextName;
        return $this;
    }
    public function getConferenceEnterPstnDisallowedNotice()
    {
        return $this->conferenceEnterPstnDisallowedNotice;
    }
    public function setConferenceEnterPstnDisallowedNotice($conferenceEnterPstnDisallowedNotice)
    {
        $this->conferenceEnterPstnDisallowedNotice = $conferenceEnterPstnDisallowedNotice;
        return $this;
    }
    public function getNumberIsBlockedMedia()
    {
        return $this->numberIsBlockedMedia;        
    }
    public function setNumberIsBlockedMedia($numberIsBlockedMedia)
    {
        $this->numberIsBlockedMedia = $numberIsBlockedMedia;
        return $this;
    }
    public function getShortDialCreateMenuPrompt()
    {
        return $this->shortDialCreateMenuPrompt;        
    }
    public function setShortDialCreateMenuPrompt($shortDialCreateMenuPrompt)
    {
    	$this->shortDialCreateMenuPrompt = $shortDialCreateMenuPrompt;
    	return $this;
    }
    public function getEmailfaxBounceUnknownUserSubject()
    {
        return $this->emailfaxBounceUnknownUserSubject;
    }
    public function setEmailfaxBounceUnknownUserSubject($emailfaxBounceUnknownUserSubject)
    {
        $this->emailfaxBounceUnknownUserSubject = $emailfaxBounceUnknownUserSubject;
        return $this;
    }    
    public function getAsteriskCallfileSpoolPath()
    {
        return $this->asteriskCallfileSpoolPath;
    }
    public function setAsteriskCallfileSpoolPath($asteriskCallfileSpoolPath)
    {
        $this->asteriskCallfileSpoolPath = $asteriskCallfileSpoolPath;
        return $this;
    }
    public function getFaxsenderContextName()
    {
        return $this->faxsenderContextName;
    }
    public function setFaxsenderContextName($faxsenderContextName)
    {
        $this->faxsenderContextName = $faxsenderContextName;
        return $this;
    }
    

    public function getFaxdialerContextName()
    {
    	return $this->faxdialerContextName;
    }
    
    public function setFaxdialerContextName($faxdialerContextName)
    {
        $this->faxdialerContextName = $faxdialerContextName;
        return $this;
    }    
    public function getFaxSendMaxTries()
    {
        return $this->faxSendMaxTries;
    }
    public function setFaxSendMaxTries($faxSendMaxTries)
    {
        $this->faxSendMaxTries = $faxSendMaxTries;
        return $this;
    }
    public function getFaxSendWaitTime()
    {
        return $this->faxSendWaitTime;
    }
    public function setFaxSendWaitTime($faxSendWaitTime)
    {
        $this->faxSendWaitTime = $faxSendWaitTime;
        return $this;
    }

 public function getFaxSpoolPath() {
  return $this->faxSpoolPath;
 }
 
 public function setFaxSpoolPath($faxSpoolPath) {
  $this->faxSpoolPath = $faxSpoolPath;
  return $this;
 }

 public function getGhostscriptBinaryPath() {
  return $this->ghostscriptBinaryPath;
 }
 
 public function setGhostscriptBinaryPath($ghostscriptBinaryPath) {
  $this->ghostscriptBinaryPath = $ghostscriptBinaryPath;
  return $this;
 }

 public function getConferenceSelectScopePrompt() {
  return $this->conferenceSelectScopePrompt;
 }
 
 public function setConferenceSelectScopePrompt($conferenceSelectScopePrompt) {
  $this->conferenceSelectScopePrompt = $conferenceSelectScopePrompt;
  return $this;
 }
 
 
 public function getMohInternalState()
    {
        if (!isset($this->mohInternalState))
        {
            $generalSettings = $this->getGeneralSettings();
            $mohInternal = $generalSettings->mohinternal;
            $this->mohInternalState = ('active'==$mohInternal);
        }
        return $this->mohInternalState;
    }
 public function setMohInternalState($mohInternalState)
 {
 	$this->mohInternalState = $mohInternalState;
 }
    
 
 public function getAlarmWrongTimeFormat()
 {
 	return $this->alarmWrongTimeFormat;
 }
 public function setAlarmWrongTimeFormat($alarmWrongTimeFormat)
 {
 	$this->alarmWrongTimeFormat = $alarmWrongTimeFormat;
 	return $this;
 }

 public function getAlarmPlayContextName()
 {
 	return $this->alarmPlayContextName;
 }
 public function setAlarmPlayContextName($alarmPlayContextName)
 {
 	$this->alarmPlayContextName = $alarmPlayContextName;
 	return $this;
 }
}
