<?php
namespace PbxAgi;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Http\Request;
use PbxAgi\EntityResolver\EntityResolverFactory;
use PbxAgi\Service\PermissionResolver\PermissionNodeFactory;
            
class Module
{

    public function onBootstrap(MvcEvent $e)
    {
     	
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        
        $moduleRouteListener->attach($eventManager);
        $this->sm = $e->getApplication()->getServiceManager();
  
        $this->prepareExceptionStrategy($e);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array(
            $this,
           'prepareExceptionViewModel'
        )); 
        $request = new Request;
        $request->setUri(implode(' ',$e->getRequest()->getContent()));
        $e->setRequest($request);
    }

    public function prepareExceptionStrategy($e)
    {
        $exceptionStrategy = $this->sm->get('ExceptionStrategy');
        $message = '';
        $exceptionStrategy->setMessage($message);
    }

    public function prepareExceptionViewModel(MvcEvent $e)
    {
        $error = $e->getError();
        if (empty($error)) {
            return;
        }
        $result = $e->getResult();
        if ($result instanceof Response) {
            return;
        }
        switch ($error) {
            // case 'error-router-no-match':
            // $sm = $this->sm;
            // $client=$sm->get('Clientimpl');
            // $loggerFacade = $client->getAsteriskLogger();
            // $loggerFacade->error('Error - route not found');
            // $client->hangup();
            // break;
            case 'error-exception':
            default:
                $exception = $e->getParam('exception');
                $client = $e->getApplication()
                    ->getServiceManager()
                    ->get('Clientimpl');
                $loggerFacade = $client->getAsteriskLogger();
                $loggerFacade->error('Unrecoverable exception occured');
            
                $client->consoleLog(implode(' ', array(
                    $exception->getMessage(),
                    $exception->getCode(),
                    $exception->getFile(),
                    $exception->getLine(),
                    $exception->getTraceAsString()
                )));
                 $client->hangup();
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
    public function getControllerConfig()
    {
         return array(
             'factories'=> array(
             	'PbxAgi\Controller\PickupFeature' => 'PbxAgi\Controller\PickupFeatureControllerFactory',             		 
                 'Dialin' => 'PbxAgi\Controller\DialInControllerFactory', 
                 'Dialout' => 'PbxAgi\Controller\DialOutControllerFactory',
             	 'Transfer' => 'PbxAgi\Controller\TransferControllerFactory', 
                 'DialCallCentre' => 'PbxAgi\Controller\DialCallCentreControllerFactory',
                 'DialExtension' => 'PbxAgi\Controller\DialExtensionControllerFactory',
                 'Pstn' => 'PbxAgi\Controller\PstnControllerFactory',
                 'RecordCall' => 'PbxAgi\Controller\RecordCallControllerFactory',
                 'ExtensionReceiveIncoming'=> 'PbxAgi\Controller\ExtensionReceiveIncomingControllerFactory',
                 'ForwardFeature' => 'PbxAgi\Controller\ForwardFeatureControllerFactory',
                 'OperatorPresenceFeature' => 'PbxAgi\Controller\OperatorPresenceFeatureControllerFactory',                 
                 'PbxAgi\Controller\ShortDialFeature' => 'PbxAgi\Controller\ShortDialFeatureControllerFactory',
              	 'PbxAgi\Controller\Feature' => 'PbxAgi\Controller\FeatureControllerFactory',	
                 'PbxAgi\Controller\ParseFaxEmail'=>'PbxAgi\Controller\ParseFaxEmailControllerFactory',	
                 'PbxAgi\Controller\VoiceMailMain' => 'PbxAgi\Controller\VoiceMailMainControllerFactory',
                 'PbxAgi\Controller\ConferenceController' =>'PbxAgi\Controller\ConferenceControllerFactory', 
                 'PbxAgi\Controller\Alarm' =>'PbxAgi\Controller\AlarmControllerFactory',
                 'PbxAgi\Controller\AlarmPlay' =>'PbxAgi\Controller\AlarmPlayControllerFactory'                 
                )
       );
    
    }
    public function getServiceConfig()
    {
        return array(
          'invokables' => array(
            'ClientImpl' => 'PbxAgi\Service\ClientImpl\ClientImpl',
            'CallOwner' => 'PbxAgi\Entity\CallOwnerEntity',
            'CallOriginator' => 'PbxAgi\Entity\CallOriginatorEntity',
            'CallDestinator' => 'PbxAgi\Entity\CallDestinatorEntity',
            'ExtensionRegexValidator' => 'PbxAgi\Validator\Extension\ExtensionRegexValidator',
            'OperatorStatusLog' => 'PbxAgi\OperatorStatusLog\Model\OperatorStatusLog',
            'PbxAgi\ChannelDescriptor\ChannelDescriptor' => 'PbxAgi\ChannelDescriptor\ChannelDescriptor',
            'PbxAgi\ChannelDescriptor\ChannelLocalDescriptor' =>'PbxAgi\ChannelDescriptor\ChannelLocalDescriptor',
            'PbxAgi\ChannelDescriptor\ChannelDescriptorInitializer' => 'PbxAgi\ChannelDescriptor\ChannelDescriptorInitializer',
            'PbxAgi\ChannelDescriptor\ChannelLocalDescriptorInitializer' => 'PbxAgi\ChannelDescriptor\ChannelLocalDescriptorInitializer',
            'PbxAgi\ChannelDescriptor\ChannelDescriptorParser' => 'PbxAgi\ChannelDescriptor\ChannelDescriptorParser',
            'PbxAgi\ChannelDescriptor\ChannelDiscriptorParseError' => 'PbxAgi\ChannelDescriptor\ChannelDiscriptorParseError',                                                 
            'PbxAgi\DialDescriptor\DialOptionsDescriptor' => 'PbxAgi\DialDescriptor\DialOptionsDescriptor',
            'PbxAgi\ChannelDescriptor\ChannelDescriptorParseError' => 'PbxAgi\ChannelDescriptor\ChannelDescriptorParseError',              
            'PbxAgi\Service\Closurize' => 'PbxAgi\Service\Closurize',
            'PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer'=>'PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer',
            'PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\NewConferencePinValidator' => 'PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\NewConferencePinValidator',
            'PbxAgi\Service\ShortDialMenu\ShortDialDataContainer' => 'PbxAgi\Service\ShortDialMenu\ShortDialDataContainer',
            'PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer' => 'PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer',               
            'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\AbstractCursorChoiceInitializer' => 'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\AbstractCursorChoiceInitializer',                       
            'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer' => 'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer',            
          	'SendmailTransport'=>'Zend\Mail\Transport\Sendmail',
          	'PbxAgi\Service\Reader\Reader'=> 'PbxAgi\Service\Reader\Reader',
          	'PbxAgi\Service\Writer\Writer' => 'PbxAgi\Service\Writer\Writer',
          	'PbxAgi\Service\Executer\Executer' => 'PbxAgi\Service\Executer\Executer',
 			'PbxAgi\DialDescriptor\DialOptions\AnnouncementDialOption'=>'PbxAgi\DialDescriptor\DialOptions\AnnouncementDialOption',
			'PbxAgi\DialDescriptor\DialOptions\ResetCDRDialOption' =>'PbxAgi\DialDescriptor\DialOptions\ResetCDRDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\AnsweredElseWhereDialOption' =>	'PbxAgi\DialDescriptor\DialOptions\AnsweredElseWhereDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\PostConnectDtmfDialOption'=>'PbxAgi\DialDescriptor\DialOptions\PostConnectDtmfDialOption',	
          	'PbxAgi\DialDescriptor\DialOptions\FeatureWhileDialingDialOption'=>'PbxAgi\DialDescriptor\DialOptions\FeatureWhileDialingDialOption',	
          	'PbxAgi\DialDescriptor\DialOptions\CallHangupExtenOnPeerDialOption'=>'PbxAgi\DialDescriptor\DialOptions\CallHangupExtenOnPeerDialOption',	
          	'PbxAgi\DialDescriptor\DialOptions\ExecExtenAfterCallerHangupDialOption' => 'PbxAgi\DialDescriptor\DialOptions\ExecExtenAfterCallerHangupDialOption',	
			'PbxAgi\DialDescriptor\DialOptions\CallerIdBasedOnDialplanHintDialOption' => 'PbxAgi\DialDescriptor\DialOptions\CallerIdBasedOnDialplanHintDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\PostConnectDialPlanTransferBothToDialOption'	=> 'PbxAgi\DialDescriptor\DialOptions\PostConnectDialPlanTransferBothToDialOption',
			'PbxAgi\DialDescriptor\DialOptions\JumpNextPriorityAfterConnectDialOption' => 'PbxAgi\DialDescriptor\DialOptions\JumpNextPriorityAfterConnectDialOption',
			'PbxAgi\DialDescriptor\DialOptions\CallerHangupStarKeyDialOption' =>	'PbxAgi\DialDescriptor\DialOptions\CallerHangupStarKeyDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\CalleeHangupStarKeyDialOption' =>	'PbxAgi\DialDescriptor\DialOptions\CalleeHangupStarKeyDialOption',          	
          	'PbxAgi\DialDescriptor\DialOptions\IgnoreForwardingDialOption' =>	'PbxAgi\DialDescriptor\DialOptions\IgnoreForwardingDialOption',
			'PbxAgi\DialDescriptor\DialOptions\JumpToPriorityDialOption' => 'PbxAgi\DialDescriptor\DialOptions\JumpToPriorityDialOption',
			'PbxAgi\DialDescriptor\DialOptions\AllowCallingCallParkDialOption' => 'PbxAgi\DialDescriptor\DialOptions\AllowCallingCallParkDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\AllowCalledCallParkDialOption' => 'PbxAgi\DialDescriptor\DialOptions\AllowCalledCallParkDialOption',
			'PbxAgi\DialDescriptor\DialOptions\LimitCallWithWarningDialOption' => 'PbxAgi\DialDescriptor\DialOptions\LimitCallWithWarningDialOption',
			'PbxAgi\DialDescriptor\DialOptions\ExecuteMacroDialOption' => 'PbxAgi\DialDescriptor\DialOptions\ExecuteMacroDialOption',
			'PbxAgi\DialDescriptor\DialOptions\RingingMohDialOption' => 'PbxAgi\DialDescriptor\DialOptions\RingingMohDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\DisableCallScreeningDialOption' => 'PbxAgi\DialDescriptor\DialOptions\DisableCallScreeningDialOption',	
          	'PbxAgi\DialDescriptor\DialOptions\DeletePmIntroductionDialOption' => 'PbxAgi\DialDescriptor\DialOptions\DeletePmIntroductionDialOption',
			'PbxAgi\DialDescriptor\DialOptions\RingBackDahdiDialOption' => 'PbxAgi\DialDescriptor\DialOptions\RingBackDahdiDialOption',          		
          	'PbxAgi\DialDescriptor\DialOptions\SendOriginalCallerIdDialOption' => 'PbxAgi\DialDescriptor\DialOptions\SendOriginalCallerIdDialOption',	
          	'PbxAgi\DialDescriptor\DialOptions\PrivacyManagerDialOption' => 'PbxAgi\DialDescriptor\DialOptions\PrivacyManagerDialOption',	
          	'PbxAgi\DialDescriptor\DialOptions\ScreeningModeDialOption' => 	'PbxAgi\DialDescriptor\DialOptions\ScreeningModeDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\RingingIndicationBristuffDialOption' => 'PbxAgi\DialDescriptor\DialOptions\RingingIndicationBristuffDialOption',	
          	'PbxAgi\DialDescriptor\DialOptions\RingingIndicationDialOption' => 'PbxAgi\DialDescriptor\DialOptions\RingingIndicationDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\HangupAfterDialOption' => 'PbxAgi\DialDescriptor\DialOptions\HangupAfterDialOption',	
			'PbxAgi\DialDescriptor\DialOptions\AllowCallerTransferDialOption' => 'PbxAgi\DialDescriptor\DialOptions\AllowCallerTransferDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\AllowCalleeTransferDialOption' => 'PbxAgi\DialDescriptor\DialOptions\AllowCalleeTransferDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\ExecSubDialOption' => 'PbxAgi\DialDescriptor\DialOptions\ExecSubDialOption',
			'PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomonDialOption' => 'PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomonDialOption',
          	'PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomonDialOption' => 'PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomonDialOption',	    
          	'PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomixerDialOption' => 'PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomixerDialOption',	      				
          	'PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomixerDialOption' => 'PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomixerDialOption',
            'PbxAgi\Service\FaxParse\FaxAttachmentFormatValidator'=> 'PbxAgi\Service\FaxParse\FaxAttachmentFormatValidator',
            'PbxAgi\Service\FaxParse\FaxRetrieveSender'=> 'PbxAgi\Service\FaxParse\FaxRetrieveSender',
            'PbxAgi\Service\FaxParse\FaxRetrieveAttachment'=> 'PbxAgi\Service\FaxParse\FaxRetrieveAttachment',            
            'PbxAgi\Validator\Time\SimpleTimeWithoutSemicolumnValidator' => 'PbxAgi\Validator\Time\SimpleTimeWithoutSemicolumnValidator',
            'PbxAgi\GenericWrappers\DateTime' =>  'PbxAgi\GenericWrappers\DateTime',
            'PbxAgi\Service\CallSpoolImpl\CallSpoolImpl' => 'PbxAgi\Service\CallSpoolImpl\CallSpoolImplFactory',
              
          ),
        'factories' => array(
            'Router' => 'PbxAgi\Router\RouterFactory', 
            'ExtensionValidator' => 'PbxAgi\Extension\Model\ExtensionValidatorFactory',
            'CallEntity' => 'PbxAgi\Entity\CallEntityFactory',
            'ChannelVarManager' => 'PbxAgi\Service\ChannelVarManager\ChannelVarManagerFactory',
            'ExtensionTable' => 'PbxAgi\Extension\Model\ExtensionTableFactory',            
            'ExtensionTableGateway' => 'PbxAgi\Extension\Model\ExtensionTableGatewayFactory',
            'OperatorTable' => 'PbxAgi\Operator\Model\OperatorTableFactory',
            'OperatorTableGateway' => 'PbxAgi\Operator\Model\OperatorTableGatewayFactory',
            'AppConfig' => 'PbxAgi\Service\AppConfig\AppConfigServiceFactory', 
            'PeerTable' => 'PbxAgi\Peer\Model\PeerTableFactory',
            'PeerTableGateway' => 'PbxAgi\Peer\Model\PeerTableGatewayFactory',
            'TrunkTableGateway' => 'PbxAgi\Trunk\Model\TrunkTableGatewayFactory',            
            'TrunkTable' => 'PbxAgi\Trunk\Model\TrunkTableFactory',  
            'OperatorStatusLogTable' => 'PbxAgi\OperatorStatusLog\Model\OperatorStatusLogTableFactory',
            'OperatorStatusLogTableGateway' => 'PbxAgi\OperatorStatusLog\Model\OperatorStatusLogTableGatewayFactory',
            'PbxAgi\ExtensionGroup\Model\ExtensionGroupTable' => 'PbxAgi\ExtensionGroup\Model\ExtensionGroupTableFactory',
            'PbxAgi\ExtensionGroup\Model\ExtensionGroupTableGateway' => 'PbxAgi\ExtensionGroup\Model\ExtensionGroupTableGatewayFactory',            
            'PbxAgi\Service\CdrManager\CdrManager' => 'PbxAgi\Service\CdrManager\CdrManagerFactory',
            'PbxAgi\DialDescriptor\DialDescriptor' => 'PbxAgi\DialDescriptor\DialDescriptorFactory',
            'PbxAgi\CallCentreStatus\Model\CallCentreStatusTable' => 'PbxAgi\CallCentreStatus\Model\CallCentreStatusTableFactory',
            'PbxAgi\CallCentreStatus\Model\CallCentreStatusTableGateway' => 'PbxAgi\CallCentreStatus\Model\CallCentreStatusTableGatewayFactory',              
            'PbxAgi\Conference\Model\ConferenceTable' => 'PbxAgi\Conference\Model\ConferenceTableFactory',
            'PbxAgi\Conference\Model\ConferenceTableGateway' => 'PbxAgi\Conference\Model\ConferenceTableGatewayFactory',
            'PbxAgi\Conference\Model\ConferenceValidator' =>'PbxAgi\Conference\Model\ConferenceValidatorFactory',
            'PbxAgi\Service\ConferenceMenu\CreateMainMenu'=>'PbxAgi\Service\ConferenceMenu\CreateMainMenuFactory',
            'PbxAgi\Service\ConferenceMenu\JoinMainMenu'=>'PbxAgi\Service\ConferenceMenu\JoinMainMenuFactory',            
            'PbxAgi\Service\ConferenceMenu\ConferenceValidator' => 'PbxAgi\Service\ConferenceMenu\ConferenceValidatorFactory',
            'PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\CreateConference' => 'PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\CreateConferenceFactory',
            'PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\BuildCreateConferenceMenu' => 'PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\BuildCreateConferenceMenuFactory',
            'PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\NewConferenceNumberValidator' => 'PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\NewConferenceNumberValidatorFactory',            
            'PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\BuildPasswordCreateMenu' => 'PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\BuildPasswordCreateMenuFactory',
            'PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\ConferencePasswordSave' => 'PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\ConferencePasswordSaveFactory',
            'PbxAgi\Service\ConferenceMenu\EnterConferenceMenu\BuildConferenceMenu' => 'PbxAgi\Service\ConferenceMenu\EnterConferenceMenu\BuildConferenceMenuFactory',
            'PbxAgi\Service\ConferenceMenu\EnterConferenceMenu\EnterConference' => 'PbxAgi\Service\ConferenceMenu\EnterConferenceMenu\EnterConferenceFactory',
            'PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu\BuildPasswordMenu' => 'PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu\BuildPasswordMenuFactory', 
            'PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu\ConferencePasswordValidator' => 'PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu\ConferencePasswordValidatorFactory',
            'PbxAgi\Service\ConferenceMenu\NodeController' => 'PbxAgi\Service\ConferenceMenu\NodeControllerFactory',
            'PbxAgi\Service\ClientImpl\HangupAndQuit' => 'PbxAgi\Service\ClientImpl\HangupAndQuitFactory',    
            'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildConfirmSaveShortDialMenu'=>'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildConfirmSaveShortDialMenuFactory',
            'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildCreateShortDialMenu' => 'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildCreateShortDialMenuFactory',
            'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\CreateShortDial' => 'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\CreateShortDialFactory',
            'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\NewShortDialValidator' => 'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\NewShortDialValidatorFactory',
            'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildPromptNewAliasNumMenu' => 'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildPromptNewAliasNumMenuFactory',
         	'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\ShortDialDstValidator'=> 'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\ShortDialDstValidatorFactory',
            'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\ShortDialNumChosen'=>'PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\ShortDialNumChosenFactory',
            'PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu\BuildDeleteShortDialMenu' => 'PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu\BuildDeleteShortDialMenuFactory',
            'PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu\DeleteShortDial' => 'PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu\DeleteShortDialFactory',
            'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\BuildIndexShortDialMenu' => 'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\BuildIndexShortDialMenuFactory',
            'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoiceCurrent' => 'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoiceCurrentFactory',
            'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoiceNext' => 'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoiceNextFactory',
            'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoicePrevious' => 'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\ChoicePreviousFactory',
            'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\PlayCurrentItem' => 'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\PlayCurrentItemFactory',
            'PbxAgi\Service\ShortDialMenu\MainMenu\BuildMainMenu' => 'PbxAgi\Service\ShortDialMenu\MainMenu\BuildMainMenuFactory',
            'PbxAgi\Service\ShortDialMenu\CreateMainMenu' => 'PbxAgi\Service\ShortDialMenu\CreateMainMenuFactory',
            'PbxAgi\Service\ShortDialMenu\NodeController' => 'PbxAgi\Service\ShortDialMenu\NodeControllerFactory',
            'PbxAgi\Service\BuildAbstractMenu\BuildGenericNode' => 'PbxAgi\Service\BuildAbstractMenu\BuildGenericNodeFactory',
            'PbxAgi\ShortDial\Model\ShortDialTable' => 'PbxAgi\ShortDial\Model\ShortDialTableFactory',
            'PbxAgi\ShortDial\Model\ShortDialTableGateway'=> 'PbxAgi\ShortDial\Model\ShortDialTableGatewayFactory',
            'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainerInitializer' => 'PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainerInitializerFactory',            
            'PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\BuildGotoShortDialMenu' => 'PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\BuildGotoShortDialMenuFactory',
            'PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\ExistingShortDialValidator'=>'PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\ExistingShortDialValidatorFactory',
            'PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\ShiftCursor'=>'PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\ShiftCursorFactory',
            'PbxAgi\Service\ShortDialMenu\ModifyShortDialMenu\BuildModifyShortDialMenu' => 'PbxAgi\Service\ShortDialMenu\ModifyShortDialMenu\BuildModifyShortDialMenuFactory',
            'PbxAgi\GeneralSettings\Model\GeneralSettingsTable' => 'PbxAgi\GeneralSettings\Model\GeneralSettingsTableFactory',
            'PbxAgi\GeneralSettings\Model\GeneralSettingsTableGateway' => 'PbxAgi\GeneralSettings\Model\GeneralSettingsTableGatewayFactory',
        	'PbxAgi\CallDestination\Model\CallDestinationTable' => 'PbxAgi\CallDestination\Model\CallDestinationTableFactory',
        	'PbxAgi\CallDestination\Model\CallDestinationTableGateway' => 'PbxAgi\CallDestination\Model\CallDestinationTableGatewayFactory',
        	'PbxAgi\EntityResolver\EntityResolverFactory'=> function($sm)
        		{
        		    return new EntityResolverFactory($sm);
        		},
			'PbxAgi\IncomingTrunk\IncomingTrunkResolver'=> 'PbxAgi\IncomingTrunk\IncomingTrunkResolverFactory',
			'PbxAgi\TrunkAssoc\Model\TrunkAssocTable' => 'PbxAgi\TrunkAssoc\Model\TrunkAssocTableFactory',
			'PbxAgi\TrunkAssoc\Model\TrunkAssocTableGateway' => 'PbxAgi\TrunkAssoc\Model\TrunkAssocTableGatewayFactory',
			'PbxAgi\Context\Model\ContextTable' => 'PbxAgi\Context\Model\ContextTableFactory',
			'PbxAgi\Context\Model\ContextTableGateway' => 'PbxAgi\Context\Model\ContextTableGatewayFactory',
			'PbxAgi\Ivr\Model\IvrTable' => 'PbxAgi\Ivr\Model\IvrTableFactory',
			'PbxAgi\Ivr\Model\IvrTableGateway' => 'PbxAgi\Ivr\Model\IvrTableGatewayFactory',
			'PbxAgi\Feature\Model\FeatureTable' => 'PbxAgi\Feature\Model\FeatureTableFactory',
			'PbxAgi\Feature\Model\FeatureTableGateway' => 'PbxAgi\Feature\Model\FeatureTableGatewayFactory',
			'PbxAgi\Service\RouteBuilder\RouteBuilder' => 'PbxAgi\Service\RouteBuilder\RouteBuilderFactory',
			'PbxAgi\Service\RouteBuilder\DestinationValidator' => 'PbxAgi\Service\RouteBuilder\DestinationValidatorFactory',	
			'PbxAgi\Service\RouteBuilder\RouteValidator' => 'PbxAgi\Service\RouteBuilder\RouteValidatorFactory',
			'PbxAgi\Route\Model\RouteTable' => 'PbxAgi\Route\Model\RouteTableFactory',
			'PbxAgi\Route\Model\RouteTableGateway' => 'PbxAgi\Route\Model\RouteTableGatewayFactory',
			'PbxAgi\NumberMatch\Model\NumberMatchTable' => 'PbxAgi\NumberMatch\Model\NumberMatchTableFactory',
			'PbxAgi\NumberMatch\Model\NumberMatchTableGateway' => 'PbxAgi\NumberMatch\Model\NumberMatchTableGatewayFactory',				
			'PbxAgi\RegEntry\Model\RegEntryTable' => 'PbxAgi\RegEntry\Model\RegEntryTableFactory',
			'PbxAgi\RegEntry\Model\RegEntryTableGateway' => 'PbxAgi\RegEntry\Model\RegEntryTableGatewayFactory',
			'PbxAgi\TrunkDestination\Model\TrunkDestinationTable' => 'PbxAgi\TrunkDestination\Model\TrunkDestinationTableFactory',
			'PbxAgi\TrunkDestination\Model\TrunkDestinationTableGateway' => 'PbxAgi\TrunkDestination\Model\TrunkDestinationTableGatewayFactory',
			'PbxAgi\Trunk\Model\TrunkTable' => 'PbxAgi\Trunk\Model\TrunkTableFactory',
			'PbxAgi\Trunk\Model\TrunkTableGateway' => 'PbxAgi\Trunk\Model\TrunkTableGatewayFactory',	
			'PbxAgi\SkypeAlias\Model\SkypeAliasTable' => 'PbxAgi\SkypeAlias\Model\SkypeAliasTableFactory',								
			'PbxAgi\SkypeAlias\Model\SkypeAliasTableGateway' => 'PbxAgi\SkypeAlias\Model\SkypeAliasTableGatewayFactory',
			'PbxAgi\Service\SkypeAliasResolver\SkypeAliasResolver' => 'PbxAgi\Service\SkypeAliasResolver\SkypeAliasResolverFactory',			
          	'PbxAgi\Service\PermissionResolver\PermissionNodeFactory'=>	
          	function($sm){
          				return new PermissionNodeFactory($sm);
          			},          		
            'PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTable' => 'PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTableFactory',
            'PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTableGateway' => 'PbxAgi\ExtensionDefaults\Model\ExtensionDefaultsTableGatewayFactory',
            'PbxAgi\Service\PermissionResolver\PermissionResolver' => 'PbxAgi\Service\PermissionResolver\PermissionResolverFactory',
            'PbxAgi\FaxSpool\Model\FaxSpoolTable' => 'PbxAgi\FaxSpool\Model\FaxSpoolTableFactory',
            'PbxAgi\FaxSpool\Model\FaxSpoolTableGateway' => 'PbxAgi\FaxSpool\Model\FaxSpoolTableGatewayFactory',
            'PbxAgi\Service\SendEmail\SendEmail' => 'PbxAgi\Service\SendEmail\SendEmailFactory',  
            'PbxAgi\FaxUser\Model\FaxUserTable' => 'PbxAgi\FaxUser\Model\FaxUserTableFactory',
            'PbxAgi\FaxUser\Model\FaxUserTableGateway' => 'PbxAgi\FaxUser\Model\FaxUserTableGatewayFactory',           
            'PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTable' => 'PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTableFactory',
            'PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTableGateway'=> 'PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTableGatewayFactory',
            'PbxAgi\Service\ConferenceMenu\Hangup\BuildHangupNode' => 'PbxAgi\Service\ConferenceMenu\Hangup\BuildHangupNodeFactory',
            'PbxAgi\Service\ConferenceMenu\Hangup\HangupCommand' => 'PbxAgi\Service\ConferenceMenu\Hangup\HangupCommandFactory',            
            'PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\BuildConferencePromptScopeMenu'=>'PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\BuildConferencePromptScopeMenuFactory',
            'PbxAgi\Service\FaxParse\FaxSenderValidator'=> 'PbxAgi\Service\FaxParse\FaxSenderValidatorFactory',
            'PbxAgi\Service\FaxParse\FaxAttachmentPresentValidator'=> 'PbxAgi\Service\FaxParse\FaxAttachmentPresentValidatorFactory',
            'PbxAgi\Service\DialString\SimpleTimeParser' => 'PbxAgi\Service\DialString\SimpleTimeParserFactory',
            'PbxAgi\Cdr\Model\CdrTable' => 'PbxAgi\Cdr\Model\CdrTableFactory',
            'PbxAgi\Cdr\Model\CdrTableGateway' => 'PbxAgi\Cdr\Model\CdrTableGateway',
            'PbxAgi\Service\VpbxidProvider\VpbxidFeature' => 'PbxAgi\Service\VpbxidProvider\VpbxidFeatureFactory',             
            'PbxAgi\Service\VpbxidProvider\VpbxidProvider'=> 'PbxAgi\Service\VpbxidProvider\VpbxidProviderFactory'
         	),
         'shared' => array(
            'CallOwner' => 'false',
            'CallOriginator' => 'false',
            'OperatorTableGateway' => 'false',
            'ExtensionTableGateway' => 'false',
            'PeerTableGateway' => 'false',
            'TrunkTableGateway' => 'false',
            'PbxAgi\ChannelDescriptor\ChannelDescriptor' => false,
            'PbxAgi\ChannelDescriptor\ChannelLocalDescriptor'=> false,
            'PbxAgi\ChannelDescriptor\ChannelDescriptorParseError' => false,     
         	'SendmailTransport' =>false,
         		'PbxAgi\DialDescriptor\DialOptions\AnnouncementDialOption'=> false,
         		'PbxAgi\DialDescriptor\DialOptions\ResetCDRDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\AnsweredElseWhereDialOption' =>	false,
         		'PbxAgi\DialDescriptor\DialOptions\PostConnectDtmfDialOption'=> false,
         		'PbxAgi\DialDescriptor\DialOptions\FeatureWhileDialingDialOption'=> false,
         		'PbxAgi\DialDescriptor\DialOptions\CallHangupExtenOnPeerDialOption'=> false,
         		'PbxAgi\DialDescriptor\DialOptions\ExecExtenAfterCallerHangupDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\CallerIdBasedOnDialplanHintDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\PostConnectDialPlanTransferBothToDialOption'	=> false,
         		'PbxAgi\DialDescriptor\DialOptions\JumpNextPriorityAfterConnectDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\CallerHangupStarKeyDialOption' =>	false,
         		'PbxAgi\DialDescriptor\DialOptions\CalleeHangupStarKeyDialOption' =>	false,
         		'PbxAgi\DialDescriptor\DialOptions\IgnoreForwardingDialOption' =>	false,
         		'PbxAgi\DialDescriptor\DialOptions\JumpToPriorityDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\AllowCallingCallParkDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\AllowCalledCallParkDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\LimitCallWithWarningDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\ExecuteMacroDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\RingingMohDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\DisableCallScreeningDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\DeletePmIntroductionDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\RingBackDahdiDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\SendOriginalCallerIdDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\PrivacyManagerDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\ScreeningModeDialOption' => 	false,
         		'PbxAgi\DialDescriptor\DialOptions\RingingIndicationBristuffDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\RingingIndicationDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\HangupAfterDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\AllowCallerTransferDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\AllowCalleeTransferDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\ExecSubDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomonDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomonDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\AllowCallerAutomixerDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptions\AllowCalleeAutomixerDialOption' => false,
         		'PbxAgi\DialDescriptor\DialOptionsDescriptor' => false,
                'PbxAgi\GenericWrappers\DateTime' => false
         )
     );
    }
    public function getControllerPluginConfig()
    {
        return array(
                'invokables' => array(            
                    'ClosurizePlugin' => 'PbxAgi\Controller\Plugin\ClosurizeControllerPlugin',
                    ),
               'factories'=>array(
                   'DialExtension' => 'PbxAgi\Controller\Plugin\DialExtensionControllerPluginFactory',
                   'RedirectorControllerPlugin' => 'PbxAgi\Controller\Plugin\RedirectorControllerPluginFactory',
                   'RecordCallPlugin' => 'PbxAgi\Controller\Plugin\RecordCallControllerPluginFactory',
                   'PrepareCallControllerPlugin'=>'PbxAgi\Controller\Plugin\PrepareCallControllerPluginFactory', 
                   'ForwardFeatureController' => 'PbxAgi\Controller\ForwardFeatureControllerFactory',
                   'FeatureCheckPermissionPlugin' => 'PbxAgi\Controller\Plugin\FeatureCheckPermissionPluginFactory',                  
                   'TransferControllerPlugin' => 'PbxAgi\Controller\Plugin\TransferControllerPluginFactory',
                   'PbxAgi\Controller\FaxReceive' => 'PbxAgi\Controller\FaxReceiveController',
                   'TimeControllerPlugin' => 'PbxAgi\Controller\Plugin\TimeControllerPluginFactory'          
                )
                );     
    }
}
