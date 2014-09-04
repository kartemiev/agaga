<?php
 
namespace Vpbxui;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\View\Model\ViewModel;
use Zend\ModuleManager\ModuleManager;
use Vpbxui\Extension\Model\Extension;
use Vpbxui\Extension\Model\ExtensionTable;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Vpbxui\Version\Version;
use Zend\View\Helper\Navigation;
use Zend\Validator\NotEmpty;

class Module
{
    protected $whitelist = array('zfcuser/login','home','vpbxui/registerpbx','createconference','wizard','pickdid','createinternal','internalapi','overview','api/freedid');
    public function onBootstrap(MvcEvent $e)
    {                    
        $sm = $e->getApplication()->getServiceManager();
 
        $authorize = $sm->get('BjyAuthorize\Service\Authorize');
        $acl = $authorize->getAcl();
        $role = $authorize->getIdentity();
        Navigation::setDefaultAcl($acl);
        Navigation::setDefaultRole($role);    
         
        $app = $e->getApplication();
        $eventManager        = $app->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $events = $eventManager->getSharedManager();
        
        
         
           $events->attach('ZfcUser\Form\Login','init', function($e) {
        	$form = $e->getTarget();
        	$form->get('identity')->setLabel('адрес электронной почты');
        	$form->get('credential')->setLabel('пароль');
        	$form->get('submit')->setlabel('вход');
          });
           $events->attach('ZfcUserAdmin\Form\CreateUser','init', function($e) {
            	$form = $e->getTarget();
            	$form->get('display_name')->setLabel('Имя пользователя');
            	$form->get('password')->setLabel('Пароль');
            	$form->get('passwordVerify')->setLabel('Подтверждение пароля');
            	 
            	$form->get('email')->setLabel('Адрес электронной почты');
            	$form->get('submit')->setlabel('создать');
            });
            
            
               $events->attach('ZfcUserAdmin\Form\EditUser','init', function($e) {
                   $form = $e->getTarget();
                   $form->get('display_name')->setLabel('Имя пользователя');
                   $form->get('password')->setLabel('Пароль');
               
                   $form->get('email')->setLabel('Адрес электронной почты');
                     
                   $form->get('submit')->setlabel('Сохранить');
               });
               
               
        $events->attach('ZfcUser\Form\RegisterFilter','init', function($e) {
        	$filter = $e->getTarget();
        $validators = $filter->get('email')->getValidatorChain()->getValidators();
        foreach ($validators as $validator) {
         if ($validator['instance'] instanceof \ZfcUser\Validator\AbstractRecord) {
        $validator['instance']->setOptions(array(
            'messageTemplates' => array(
                'recordFound' => 'Пользователь с таким адресом электронной почты уже зарегистрирован',
            ),
        ));
        }
        }
        
        foreach ($filter->getInputs() as $input)
        {
            $notEmpty = new NotEmpty(array('breakChainOnFailure'=>true));
            $notEmpty->setMessage('поле не может быть пустым','isEmpty');
             $validators = $input->getValidatorChain()->prependValidator($notEmpty,true);
         }
        
        });
            $sm  = $app->getServiceManager();
            
            $list = $this->whitelist;
            $auth = $sm->get('zfcuser_auth_service');
            $eventManager->attach(MvcEvent::EVENT_ROUTE, function($e)
            {
            	
                
            });
            
             $eventManager->attach(MvcEvent::EVENT_RENDER, array($this, 'setVariableToLayout'), 100);        

             $eventManager->attach(MvcEvent::EVENT_ROUTE, function($e) use ($list, $auth) {
                 $s=new \Zend\EventManager\Event;
                  
            	$match = $e->getRouteMatch();
            	// No route match, this is a 404
            	
            	 
            	if (!$match instanceof RouteMatch) {
            		return;
            	}
            
            	// Route is whitelisted
            	$name = $match->getMatchedRouteName();
            	if (in_array($name, $list)) {
              		return;
            	}
            
            	// User is authenticated
            	if ($auth->hasIdentity()) {
             		return;
            	}
            
            	// Redirect to the user login page, as an example
            	$redirect = implode('=',array('redirect', urlencode($e->getRequest()->getRequestUri())));
            	 
            	$router   = $e->getRouter();
            	$url      = $router->assemble(array(), array(
            			'name' => 'zfcuser/login'
            	));
            	
             	$response = $e->getResponse();
            	$response->getHeaders()->addHeaderLine('Location', $url.'?'.$redirect);
            	$response->setStatusCode(302);
            
            	return $response;
            }, -100);
    }
  
     public function setVariableToLayout($event)
{
    $viewModel = $event->getViewModel();
  
    $sm = $event->getApplication()->getServiceManager();
  /*      
         $viewModel->setVariables(array(
        'version' => Version::VERSION_NUMBER,
        'build' => Version::GIT_HASH_NUMBER,
      )
      
      );
      */
}
    


    public function getConfig()
    {
        
        return include __DIR__ . '/config/module.config.php';
    }
    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach('*', 'dispatch', function($e) {
   $flashMessenger = new \Zend\Mvc\Controller\Plugin\FlashMessenger();
               $flashMessenger->setNamespace('zfcuser-login-form')->addMessage('для доступа необходима авторизация');
               });
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getServiceConfig()
    {
        return array(
            'invokables'=> array(
                'Vpbxui\Service\PasswordGen\PasswordGen' => 'Vpbxui\Service\PasswordGen\PasswordGen',
            	'Vpbxui\DateTime'=>'\DateTime',
            	'Vpbxui\Service\VpbxContainer'=>'Vpbxui\Service\VpbxContainer'
            ),
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'AmiClient' => 'Vpxui\Service\AmiClientServiceFactory',
            'ClientImpl' => 'Vpxui\Service\ClientImplFactory',
             'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',              
            'Vpbxui\Extension\Model\Extension' => 'Vpbxui\Extension\Model\ExtensionFactory',
            'Vpbxui\Extension\Model\ExtensionTable' =>  'Vpbxui\Extension\Model\ExtensionTableFactory',
            'Vpbxui\Status\Model\AmiGateway' => 'Vpbxui\Service\AmiClientServiceFactory', 
            'Vpbxui\Status\Model\StatusCommand' => 'Vpbxui\Status\Model\StatusCommandFactory',                    
            'ExtensionTableGateway' => 'Vpbxui\Extension\Model\ExtensionTableGatewayFactory',
            'Vpbxui\Cdr\Model\CdrTable' => 'Vpbxui\Cdr\Model\CdrTableFactory',
            'Vpbxui\Cdr\Model\CdrTableGateway' => 'Vpbxui\Cdr\Model\CdrTableGatewayFactory',
            'Vpbxui\Prune\Model\PruneCommand'=>'Vpbxui\Prune\Model\PruneCommandFactory',
            'Vpbxui\Role\Model\RoleTable' => 'Vpbxui\Role\Model\RoleTableFactory',
            'Vpbxui\Role\Model\RoleTableGateway' => 'Vpbxui\Role\Model\RoleTableGatewayFactory',    
            'Vpbxui\Roles\Model\RolesTable' => 'Vpbxui\Roles\Model\RolesTableFactory',
            'Vpbxui\Roles\Model\RolesTableGateway' => 'Vpbxui\Roles\Model\RolesTableGatewayFactory',
            'Vpbxui\CdrMissedCallsCallCentre\Model\CdrMissedCallsCallCentreTable' => 'Vpbxui\CdrMissedCallsCallCentre\Model\CdrMissedCallsCallCentreTableFactory',
            'Vpbxui\CdrMissedCallsCallCentre\Model\CdrMissedCallsCallCentreTableGateway' =>'Vpbxui\CdrMissedCallsCallCentre\Model\CdrMissedCallsCallCentreTableGatewayFactory'
            ,'Vpbxui\CallCentreStat\Model\CallCentreStatTable' => 'Vpbxui\CallCentreStat\Model\CallCentreStatTableFactory'                       
            ,'Vpbxui\CallCentreStat\Model\CallCentreStatTableGateway' => 'Vpbxui\CallCentreStat\Model\CallCentreStatTableGatewayFactory'
            ,'Vpbxui\Extension\Form\ExtensionForm' => 'Vpbxui\Extension\Form\ExtensionFormFactory'
            ,'Vpbxui\ExtensionGroup\Model\ExtensionGroupTable' => 'Vpbxui\ExtensionGroup\Model\ExtensionGroupTableFactory',
            'Vpbxui\ExtensionGroup\Model\ExtensionGroupTableGateway' => 'Vpbxui\ExtensionGroup\Model\ExtensionGroupTableGatewayFactory',
            'Vpbxui\PickupGroup\Model\PickupGroupTable' => 'Vpbxui\PickupGroup\Model\PickupGroupTableFactory',
            'Vpbxui\PickupGroup\Model\PickupGroupTableGateway' => 'Vpbxui\PickupGroup\Model\PickupGroupTableGatewayFactory',            
            'Vpbxui\Role\Model\RoleTable' => 'Vpbxui\Role\Model\RoleTableFactory',
            'Vpbxui\Role\Model\RoleTableGateway' => 'Vpbxui\Role\Model\RoleTableGatewayFactory',
            'Vpbxui\UserRole\Form\UserRoleForm' => 'Vpbxui\UserRole\Form\UserRoleFormFactory',
            'Vpbxui\UserRole\Model\UserRoleTable' => 'Vpbxui\UserRole\Model\UserRoleTableFactory',
            'Vpbxui\UserRole\Model\UserRoleTableGateway' => 'Vpbxui\UserRole\Model\UserRoleTableGatewayFactory',
            'Vpbxui\ExtensionProfile\Form\ExtensionProfileForm' => 'Vpbxui\ExtensionProfile\Form\ExtensionProfileFormFactory',
            'Vpbxui\ExtensionProfile\Model\ExtensionProfile' => 'Vpbxui\ExtensionProfile\Model\ExtensionProfileFactory',
            'Vpbxui\ExtensionProfile\Model\ExtensionProfileTable' => 'Vpbxui\ExtensionProfile\Model\ExtensionProfileTableFactory',
            'Vpbxui\ExtensionProfile\Model\ExtensionProfileTableGateway' => 'Vpbxui\ExtensionProfile\Model\ExtensionProfileTableGatewayFactory',
            'Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTable' => 'Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTableFactory',
            'Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTableGateway' => 'Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTableGatewayFactory',
            'Vpbxui\ExtensionGroupProfile\Form\ExtensionGroupProfileForm' => 'Vpbxui\ExtensionGroupProfile\Form\ExtensionGroupProfileForm',
            'Vpbxui\Extension\Form\ExtensionProfilePickerForm' => 'Vpbxui\Extension\Form\ExtensionProfilePickerFormFactory',
            'Vpbxui\Extension\Model\ExtensionProfilePicker' => 'Vpbxui\Extension\Model\ExtensionProfilePickerFactory',
            'Vpbxui\ExtensionGroup\Form\ExtensionGroupProfilePickerForm' => 'Vpbxui\ExtensionGroup\Form\ExtensionGroupProfilePickerFormFactory',            
            'Vpbxui\ExtensionGroup\Model\ExtensionGroupProfilePicker' => 'Vpbxui\ExtensionGroup\Model\ExtensionGroupProfilePickerFactory',
            'Vpbxui\OperatorStat\Model\OperatorStatTable' => 'Vpbxui\OperatorStat\Model\OperatorStatTableFactory',
            'Vpbxui\OperatorStat\Model\OperatorStatTableGateway'=>'Vpbxui\OperatorStat\Model\OperatorStatTableGatewayFactory',
            'Navigation' => 'Vpbxui\Navigation\PopulatedNavigationFactory',
            'Vpbxui\FreeExtension\Model\FreeExtension'=> 'Vpbxui\FreeExtension\Model\FreeExtensionFactory',
            'Vpbxui\FreeExtension\Model\FreeExtensionTable' => 'Vpbxui\FreeExtension\Model\FreeExtensionTableFactory',             
            'Vpbxui\FreeExtension\Model\FreeExtensionTableGateway' => 'Vpbxui\FreeExtension\Model\FreeExtensionTableGatewayFactory',
            'Vpbxui\Restart\Model\RestartCommand' => 'Vpbxui\Restart\Model\RestartCommandFactory',
            'Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTable' => 'Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTableFactory',
            'Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTableGateway' => 'Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTableGatewayFactory',
            'Vpbxui\CallCentreStatus\Model\CallCentreStatusTable' => 'Vpbxui\CallCentreStatus\Model\CallCentreStatusTableFactory',
            'Vpbxui\CallCentreStatus\Model\CallCentreStatusTableGateway' => 'Vpbxui\CallCentreStatus\Model\CallCentreStatusTableGatewayFactory',
            'Vpbxui\PbxSettings\Model\PbxSettingsTable' => 'Vpbxui\PbxSettings\Model\PbxSettingsTableFactory',
            'Vpbxui\PbxSettings\Model\PbxSettingsTableGateway' => 'Vpbxui\PbxSettings\Model\PbxSettingsTableGatewayFactory',
            'Vpbxui\Offday\Model\OffdayTable' => 'Vpbxui\Offday\Model\OffdayTableFactory',
            'Vpbxui\Offday\Model\OffdayTableGateway' => 'Vpbxui\Offday\Model\OffdayTableGatewayFactory',            
            'Vpbxui\GeneralSettings\Model\GeneralSettingsTable' => 'Vpbxui\GeneralSettings\Model\GeneralSettingsTableFactory',
            'Vpbxui\GeneralSettings\Model\GeneralSettingsTableGateway' => 'Vpbxui\GeneralSettings\Model\GeneralSettingsTableGatewayFactory',
            'Vpbxui\MediaRepos\Model\MediaReposTable'=> 'Vpbxui\MediaRepos\Model\MediaReposTableFactory',
            'Vpbxui\MediaRepos\Model\MediaReposTableGateway' => 'Vpbxui\MediaRepos\Model\MediaReposTableGatewayFactory',
            'Vpbxui\GeneralSettings\Form\GeneralSettingsForm' => 'Vpbxui\GeneralSettings\Form\GeneralSettingsFormFactory',
            'Vpbxui\Conference\Form\ConferenceForm' => 'Vpbxui\Conference\Form\ConferenceFormFactory',
            'Vpbxui\Conference\Model\ConferenceTable' => 'Vpbxui\Conference\Model\ConferenceTableFactory',
            'Vpbxui\Conference\Model\ConferenceTableGateway' => 'Vpbxui\Conference\Model\ConferenceTableGatewayFactory',
            'Vpbxui\ConferenceFree\Model\ConferenceFreeTable' => 'Vpbxui\ConferenceFree\Model\ConferenceFreeTableFactory',
            'Vpbxui\ConferenceFree\Model\ConferenceFreeTableGateway' => 'Vpbxui\ConferenceFree\Model\ConferenceFreeTableGatewayFactory',
        	'Vpbxui\CallDestination\Model\CallDestinationTable' => 'Vpbxui\CallDestination\Model\CallDestinationTableFactory',
        	'Vpbxui\CallDestination\Model\CallDestinationTableGateway' => 'Vpbxui\CallDestination\Model\CallDestinationTableGatewayFactory',
        	'Vpbxui\SkypeAlias\Model\SkypeAliasTable' => 'Vpbxui\SkypeAlias\Model\SkypeAliasTableFactory',
        	'Vpbxui\SkypeAlias\Model\SkypeAliasTableGateway'=> 'Vpbxui\SkypeAlias\Model\SkypeAliasTableGatewayFactory',
        	'Vpbxui\SkypeAlias\Model\SkypeAlias' => 'Vpbxui\SkypeAlias\Model\SkypeAliasFactory',
        	'Vpbxui\Trunk\Model\TrunkTable' =>	'Vpbxui\Trunk\Model\TrunkTableFactory',
        	'Vpbxui\Trunk\Model\TrunkTableGateway' => 'Vpbxui\Trunk\Model\TrunkTableGatewayFactory',
        	'Vpbxui\Context\Model\Context' => 'Vpbxui\Context\Model\ContextFactory', 	
        	'Vpbxui\Context\Model\ContextTable' => 'Vpbxui\Context\Model\ContextTableFactory',
        	'Vpbxui\Context\Model\ContextTableGateway' => 'Vpbxui\Context\Model\ContextTableGatewayFactory',
         	'Vpbxui\Context\Form\TrunkFieldset' => 'Vpbxui\Context\Form\TrunkFieldsetFactory',        		
        	'Vpbxui\Ivr\Model\IvrTable' => 'Vpbxui\Ivr\Model\IvrTableFactory', 
        	'Vpbxui\Ivr\Model\IvrTableGateway' => 'Vpbxui\Ivr\Model\IvrTableGatewayFactory',
        	'Vpbxui\TrunkAssoc\Model\TrunkAssocTable' => 'Vpbxui\TrunkAssoc\Model\TrunkAssocTableFactory',
        	'Vpbxui\TrunkAssoc\Model\TrunkAssocTableGateway' => 'Vpbxui\TrunkAssoc\Model\TrunkAssocTableGatewayFactory',		        		
        	'Vpbxui\Context\Form\ContextForm' => 'Vpbxui\Context\Form\ContextFormFactory',
        	'Vpbxui\Reload\Model\ReloadCommand' => 'Vpbxui\Reload\Model\ReloadCommandFactory',
        	'Vpbxui\Feature\Model\FeatureTable' => 'Vpbxui\Feature\Model\FeatureTableFactory',
        	'Vpbxui\Feature\Model\FeatureTableGateway' => 'Vpbxui\Feature\Model\FeatureTableGatewayFactory',
        	'Vpbxui\Route\Model\RouteTable' => 'Vpbxui\Route\Model\RouteTableFactory',
        	'Vpbxui\Route\Model\RouteTableGateway' => 'Vpbxui\Route\Model\RouteTableGatewayFactory',
        	'Vpbxui\Route\Form\RouteForm' => 'Vpbxui\Route\Form\RouteFormFactory',
        	'Vpbxui\Route\Form\RouteDestinationFieldset' => 'Vpbxui\Route\Form\RouteDestinationFieldsetFactory',
        	'Vpbxui\NumberMatch\Model\NumberMatchTable' => 'Vpbxui\NumberMatch\Model\NumberMatchTableFactory',        		
        	'Vpbxui\NumberMatch\Model\NumberMatchTableGateway' => 'Vpbxui\NumberMatch\Model\NumberMatchTableGatewayFactory',
        	'Vpbxui\RegEntry\Model\RegEntryTable' => 'Vpbxui\RegEntry\Model\RegEntryTableFactory',
        	'Vpbxui\RegEntry\Model\RegEntryTableGateway' => 'Vpbxui\RegEntry\Model\RegEntryTableGatewayFactory',
        	'Vpbxui\TrunkDestination\Model\TrunkDestinationTable' => 'Vpbxui\TrunkDestination\Model\TrunkDestinationTableFactory',	        		
        	'Vpbxui\TrunkDestination\Model\TrunkDestinationTableGateway' => 'Vpbxui\TrunkDestination\Model\TrunkDestinationTableGatewayFactory',
        	'Vpbxui\ExtensionDefaults\Model\ExtensionDefaultsTable' =>	'Vpbxui\ExtensionDefaults\Model\ExtensionDefaultsTableFactory',	        		        		
        	'Vpbxui\ExtensionDefaults\Model\ExtensionDefaultsTableGateway' =>	'Vpbxui\ExtensionDefaults\Model\ExtensionDefaultsTableGatewayFactory',        		
        	'Vpbxui\Registry\Model\RegistryCommand' => 'Vpbxui\Registry\Model\RegistryCommandFactory',
        	'Vpbxui\FaxUser\Model\FaxUserTable'=>'Vpbxui\FaxUser\Model\FaxUserTableFactory',
        	'Vpbxui\FaxUser\Model\FaxUserTableGateway'=>'Vpbxui\FaxUser\Model\FaxUserTableGatewayFactory',
        	'Vpbxui\FaxUserEmail\Model\FaxUserEmailTable'=>'Vpbxui\FaxUserEmail\Model\FaxUserEmailTableFactory',
        	'Vpbxui\FaxUserEmail\Model\FaxUserEmailTableGateway'=>'Vpbxui\FaxUserEmail\Model\FaxUserEmailTableGatewayFactory',
        	'Vpbxui\Conference\Model\Conference' => 'Vpbxui\Conference\Model\ConferenceFactory',
        	'Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTable' => 'Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTableFactory',
        	'Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTableGateway' => 'Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTableGatewayFactory',
        	'Vpbxui\CallCentreSchedule\Model\TimeSpotTable' => 'Vpbxui\CallCentreSchedule\Model\TimeSpotTableFactory',
        	'Vpbxui\CallCentreSchedule\Model\TimeSpotTableGateway' => 'Vpbxui\CallCentreSchedule\Model\TimeSpotTableGatewayFactory',
        	'Vpbxui\AuthCode\Model\AuthCodeTable'=> 'Vpbxui\AuthCode\Model\AuthCodeTableFactory',
        	'Vpbxui\AuthCode\Model\AuthCodeTableGateway' => 'Vpbxui\AuthCode\Model\AuthCodeTableGatewayFactory', 
        	'Vpbxui\UserVpbxLinker\Model\UserVpbxLinkerTable'=> 'Vpbxui\UserVpbxLinker\Model\UserVpbxLinkerTableFactory',
        	'Vpbxui\UserVpbxLinker\Model\UserVpbxLinkerTableGateway'=> 'Vpbxui\UserVpbxLinker\Model\UserVpbxLinkerTableGatewayFactory',
        	'Vpbxui\Service\VpbxidProvider\VpbxidProvider' => 'Vpbxui\Service\VpbxidProvider\VpbxidProviderFactory',
            'Vpbxui\FeatureTest\Model\FeatureTestTable'=>'Vpbxui\FeatureTest\Model\FeatureTestTableFactory',
            'Vpbxui\FeatureTest\Model\FeatureTestTableGateway'=>'Vpbxui\FeatureTest\Model\FeatureTestTableGatewayFactory',
            'Vpbxui\Service\VpbxidProvider\VpbxidFeature'=>'Vpbxui\Service\VpbxidProvider\VpbxidFeatureFactory'       		
           ),
        'shared'=>array(
        		'navigation'=>'false',
        		'Vpbxui\Context\Model\Context' => false
        		),
            'allow_override' => array(
                'Navigation' => true,
            ),
	    );
    }
    public function getControllerConfig()
    {
         return array(
         'invokables' => array(
            'Vpbxui\Controller\Index' => 'Vpbxui\Controller\IndexController',
            'Vpbxui\Controller\Internal' => 'Vpbxui\Controller\InternalController',
            'Vpbxui\Controller\Callcentre' => 'Vpbxui\Controller\CallcentreController',
            'Vpbxui\Controller\Operator' => 'Vpbxui\Controller\OperatorController',
            'Vpbxui\Controller\Cdr' => 'Vpbxui\Controller\CdrController',        
            'Vpbxui\Controller\CallCentreStats' => 'Vpbxui\Controller\CallCentreStatsController',
            'Vpbxui\Controller\CallCentreStatsGeneral' => 'Vpbxui\Controller\CallCentreStatsGeneralController',
            'Vpbxui\Controller\CallCentreStatsOperators' => 'Vpbxui\Controller\CallCentreStatsOperatorsController',
            'Vpbxui\Controller\CallCentreMonitoring' => 'Vpbxui\Controller\CallCentreMonitoringController',
            'Vpbxui\Controller\CallCentreStatsGeneral' => 'Vpbxui\Controller\CallCentreStatsGeneralController',
            'Vpbxui\Controller\CdrMissedCallsCallCentre' => 'Vpbxui\Controller\CdrMissedCallsCallCentreController',
            'Vpbxui\Controller\ExtensionGroup' => 'Vpbxui\Controller\ExtensionGroupController',
            'Vpbxui\Controller\Settings' => 'Vpbxui\Controller\SettingsController',
            'Vpbxui\Controller\PickupGroup' => 'Vpbxui\Controller\PickupGroupController',
            'Vpbxui\Controller\Users' => 'Vpbxui\Controller\UsersController',
            'Vpbxui\Controller\UserRoles' => 'Vpbxui\Controller\UserRolesController',      
            'Vpbxui\Controller\InternalProfile' => 'Vpbxui\Controller\InternalProfileController',
            'Vpbxui\Controller\InternalGroupProfile' => 'Vpbxui\Controller\InternalGroupProfileController',
            'Vpbxui\Controller\Offday' =>   'Vpbxui\Controller\OffdayController',    
         	'Vpbxui\Controller\SkypeAlias' => 'Vpbxui\Controller\SkypeAliasController',
         	'Vpbxui\Controller\Trunk' => 'Vpbxui\Controller\TrunkController',
         	'Vpbxui\Controller\Context' => 'Vpbxui\Controller\ContextController',
         	'Vpbxui\Controller\Ivr' => 'Vpbxui\Controller\IvrController',
         	'Vpbxui\Controller\Route' => 'Vpbxui\Controller\RouteController',
         	'Vpbxui\Controller\NumberMatch' => 'Vpbxui\Controller\NumberMatchController',
         	'Vpbxui\Controller\ExtensionDefaults'=>	'Vpbxui\Controller\ExtensionDefaultsController',
         	'Vpbxui\Controller\FaxUser'=> 'Vpbxui\Controller\FaxUserControllerFactory',
         	'Vpbxui\Controller\CallCentreSettings' => 'Vpbxui\Controller\CallCentreSettingsController'          	         		
            ),
        'factories'=> array(
        	'Vpbxui\Controller\Monitoring'=>'Vpbxui\Controller\MonitoringControllerFactory',        		
            'Vpbxui\Controller\StatController' => 'Vpbxui\Controller\StatControllerFactory',
            'Vpbxui\Controller\UserController'=>'Vpbxui\Controller\UserControllerFactory', 
            'Vpbxui\Controller\GeneralSettings' => 'Vpbxui\Controller\GeneralSettingsControllerFactory',
            'Vpbxui\Controller\MediaRepos' => 'Vpbxui\Controller\MediaReposControllerFactory',          
            'Vpbxui\Controller\ConferenceBooking' => 'Vpbxui\Controller\ConferenceBookingControllerFactory',
        	'Vpbxui\Controller\CallCentreSchedule' => 'Vpbxui\Controller\CallCentreScheduleControllerFactory',
        	'Vpbxui\Controller\AuthCode' =>	 'Vpbxui\Controller\AuthCodeControllerFactory',
        	'Vpbxui\Controller\RegisterPbx' => 'Vpbxui\Controller\RegisterPbxControllerFactory'
            ),
     );
    }
     
    public function getControllerPluginConfig()
    {
        return array(
            'invokables'=>array(
                'ReportScopeFilterControllerPlugin' => 'Vpbxui\Controller\Plugin\ReportScopeFilterControllerPlugin'
            )
            );
    }    
    
}
