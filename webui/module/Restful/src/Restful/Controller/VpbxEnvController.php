<?php
namespace Restful\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Vpbxui\Extension\Model\ExtensionTableInterface;
use Saas\VpbxEnv\Model\VpbxEnvTableInterface;
use Vpbxui\MediaRepos\Model\MediaReposTableInterface;
use Vpbxui\GeneralSettings\Model\GeneralSettingsTable;
use Vpbxui\MediaRepos\Model\MediaRepos;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Vpbxui\Controller\MediaReposController;
use Vpbxui\Service\VpbxidProvider\VpbxidProviderInterface;
use Vpbxui\Trunk\Model\Trunk;
use Vpbxui\Trunk\Model\TrunkTableInterface;
use Vpbxui\TrunkAssoc\Model\TrunkAssocTableInterface;
use Vpbxui\Context\Model\ContextTableInterface;
use Vpbxui\Ivr\Model\IvrTableInterface;
use Vpbxui\Context\Model\Context;
use Vpbxui\Ivr\Model\Ivr;
use Vpbxui\TrunkAssoc\Model\TrunkAssoc;
use Vpbxui\ExtensionGroup\Model\ExtensionGroupTable;
use Vpbxui\ExtensionGroup\Model\ExtensionGroup;
use Zend\Db\Adapter\AdapterInterface;
use Vpbxui\Route\Model\RouteTableInterface;
use Vpbxui\Route\Model\Route;
use Vpbxui\RegEntry\Model\RegEntryTableInterface;
use Vpbxui\NumberMatch\Model\NumberMatchTableInterface;
use Vpbxui\RegEntry\Model\RegEntry;
use Vpbxui\NumberMatch\Model\NumberMatch;
use Vpbxui\TrunkDestination\Model\TrunkDestinationTableInterface;
use Vpbxui\TrunkDestination\Model\TrunkDestination;
use Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTableInterface;
use Vpbxui\CallCentreSchedule\Model\CallCentreSchedule;
use Vpbxui\Extension\Model\Extension;
use Saas\WizardSessionContainer\WizardSessionContainerInterface;
use Saas\Controller\UploadMediaController;
use Saas\WizardSessionContainer\MediaTypeMapperNamingStrategy;
use Zend\View\Model\JsonModel;
use Restful\Service\AppConfig\AppConfigInterface;

class VpbxEnvController extends AbstractRestfulController
{
    private $wizardSessionContainer;
    private $generalSettingsTable;
    private $extensionTable;
    private $mediaReposTable;
    private $vpbxEnvTable;
    protected $vpbxId;
    protected $vpbxidProvider;
    protected $vpbxEnv;
    protected $trunkTable;
    protected $trunkAssocTable;
    protected $contextTable;
    protected $ivrTable;
    protected $context;
    protected $extensionGroupTable;
    protected $extension;
    protected $dbAdapter;
    protected $routeTable;
    protected $regEntryTable;
    protected $numberMatchTable;
    protected $trunkDestinationTable;
    protected $trunkId;
    protected $callCentreScheduleTable;
    protected $appConfig;
	public function __construct(
			WizardSessionContainerInterface $wizardSessionContainer, 
			ExtensionTableInterface $extensionTable, 
			VpbxEnvTableInterface $vpbxEnvTable,
			MediaReposTableInterface $mediaReposTable,
			GeneralSettingsTable $generalSettingsTable,
			VpbxidProviderInterface $vpbxidProvider,
			TrunkTableInterface $trunkTable,
			TrunkAssocTableInterface $trunkAssocTable,
			ContextTableInterface $contextTable,
			IvrTableInterface $ivrTable,
			Context $context,
			ExtensionGroupTable $extensionGroupTable,
			Extension $extension,
			AdapterInterface $dbAdapter,
			RouteTableInterface $routeTable,
			RegEntryTableInterface $regEntryTable,
			NumberMatchTableInterface $numberMatchTable,
			TrunkDestinationTableInterface $trunkDestinationTable,
			CallCentreScheduleTableInterface $callCentreScheduleTable,
	       AppConfigInterface $appConfig
	)
	{
		$this->wizardSessionContainer = $wizardSessionContainer;
		$this->extensionTable = $extensionTable;
		$this->vpbxEnvTable = $vpbxEnvTable;
		$this->mediaReposTable = $mediaReposTable;
		$this->generalSettingsTable = $generalSettingsTable;
		$this->vpbxidProvider = $vpbxidProvider;
		$this->trunkTable = $trunkTable;
		$this->trunkAssocTable = $trunkAssocTable;
		$this->contextTable = $contextTable;
		$this->ivrTable = $ivrTable;
		$this->extensionGroupTable = $extensionGroupTable;
		$this->extension = $extension;
		$this->dbAdapter = $dbAdapter;
		$this->routeTable = $routeTable;
		$this->regEntryTable = $regEntryTable;
		$this->numberMatchTable = $numberMatchTable;
		$this->trunkDestinationTable = $trunkDestinationTable;
		$this->callCentreScheduleTable = $callCentreScheduleTable;
		$this->context = $context;
		$this->appConfig = $appConfig;
	}
	public function create($data)
	{
	    $this->processVpbxEnv();
	    $this->processMedia(); 	    
	    $this->processTrunksAndContext();     
	    $this->processInternal();	    
	    $this->processRoute();
	    $this->processCallCentre();
	    $this->markCompletedWizardActionsCompleted();
	    $this->getResponse()->setStatusCode(201);
	   
	    return new JsonModel(array('success'=>true));
	}
	protected function processMedia()
	{
	    $mediaStageCompleted = (isset($this->wizardSessionContainer->wizardActionsCompletedList['process_media']))?$this->wizardSessionContainer->wizardActionsCompletedList['process_media']:false;
	    if (!$mediaStageCompleted)
	    {
	       $this->mediaReposTable->deleteAllMediaRepos();
	       $media = $this->wizardSessionContainer->media;
	       $hydrator = new ObjectProperty();
	       $mediaTypeMapperNamingStrategy = new MediaTypeMapperNamingStrategy();
	       $generalSettingsTable = $this->generalSettingsTable;
	       $vpbxId = $this->getVpbxId();
	       $generalSettings = $this->generalSettingsTable->getSettings($vpbxId);
	       if ($media)
	       {
	        foreach ($media as $type => $tmpMedia)
	        {
	            $mediaRepos = new MediaRepos();
	            $data = $hydrator->extract($tmpMedia);
	            unset($data['id']);
	            $hydrator->hydrate($data, $mediaRepos);
	            $mediaRepos->mediatype = 'ANYMEDIA';
	            $mediaRepos->vpbxid = $this->vpbxId;
	            $id = $this->mediaReposTable->saveMediaRepos($mediaRepos);
	            rename(UploadMediaController::TMP_MEDIA_PATH.'/'.$tmpMedia->id, MediaReposController::VPBX_MEDIAREPOSDIR.'/'.$id);
	            if (!$mediaTypeMapperNamingStrategy->hydrate($type))
	            {
	                continue;
	            }
	               $propertyName = $mediaTypeMapperNamingStrategy->hydrate($type);
	               $generalSettings->$propertyName = $id;
	           }
	           $generalSettingsTable->saveSettings($generalSettings);
	       }
	       $this->wizardSessionContainer->wizardActionsCompletedList['process_media'] = true;
	     
	    } 
	    return $this;
	}
	protected function processVpbxEnv()
	{
	    $vpbxEnvStageCompleted = (isset($this->wizardSessionContainer->wizardActionsCompletedList['process_vpbx_env']))?$this->wizardSessionContainer->wizardActionsCompletedList['process_vpbx_env']:false;
	    if (!$vpbxEnvStageCompleted)
	    {
	       $vpbxEnv = $this->wizardSessionContainer->vpbxEnv;
	       $vpbxEnv->vpbx_name = 'виртульная АТС для тестов';
	       $vpbxEnv->vpbx_description = 'виртульная АТС для тестов';
	       $vpbxEnv->vpbx_remotevpbxid = (string)$this->getVpbxId();
	       $vpbxEnv->limitplan = $this->appConfig->getLimitPlan();
	       $did = $this->wizardSessionContainer->did;
	       $vpbxEnv->outgoingtrunk_did = $did->id;
 	      if ($vpbxEnv)
	       {
	           $this->vpbxEnv = $this->vpbxEnvTable->saveVpbxEnv($vpbxEnv);
	       }
	       $this->wizardSessionContainer->wizardActionsCompletedList['process_vpbx_env'] = true;
	    } 
	    return $this;
	}
	protected function processTrunksAndContext()
	{
	    $processTrunksAndContextStageCompleted = (isset($this->wizardSessionContainer->wizardActionsCompletedList['process_trunks_and_context']))?$this->wizardSessionContainer->wizardActionsCompletedList['process_trunks_and_context']:false;

	    if (!$processTrunksAndContextStageCompleted)
	    {
	       $this->trunkTable->deleteAllTrunks();
	       $vpbxEnv = $this->vpbxEnv;
	       $trunk = new Trunk();
	
	       $trunk->name = $vpbxEnv->sip_name;
	       $trunk->secret = $vpbxEnv->sip_secret;
	       $trunk->host = 'serv-02';
	       $trunk->port = '5060';
	       $trunk->callbackextension = $vpbxEnv->sip_name;
	       $trunk->context = 'vpbx_dialout';

	       $trunkId = $this->trunkTable->saveTrunk($trunk);
	       $this->trunkId  = $trunkId;

	       $this->ivrTable->deleteAllIvrs();
	       
	       $ivr = new Ivr();
	       $ivr->custname = 'основной';
	       $ivr->custdesc = 'основной';
	       $ivrId = $this->ivrTable->saveIvr($ivr);
	    
	       $this->contextTable->deleteAllContexts();
	       
	       $context = clone $this->context;
	       $data = array(
	        'custname' => 'основной',
	        'custdesc' => 'основной',
	        'contexttype' => 'IVR',
	        'ivrref'=>$ivrId
	       );
	       $context->exchangeArray($data);
	       $contextId = $this->contextTable->saveContext($context);
	
	       $this->trunkAssocTable->deleteAllTrunkAssoc();
	       
	       $trunkAssoc = new TrunkAssoc();
	       $data = array(
	        'trunkref'=>$trunkId,
	        'contextref'=>$contextId
	       );
	       $trunkAssoc->exchangeArray($data);
	     
	       $this->trunkAssocTable->saveTrunkAssoc($trunkAssoc);
	       $this->wizardSessionContainer->wizardActionsCompletedList['process_trunks_and_context'] = true;
	       
	    } 
	    return $this;
	}
	protected function processInternal()
	{
	    $internalNumbersStageCompleted = (isset($this->wizardSessionContainer->wizardActionsCompletedList['process_internal']))?$this->wizardSessionContainer->wizardActionsCompletedList['process_internal']:false;
	    if (!$internalNumbersStageCompleted)
	    {
	       $internalnumbers = $this->wizardSessionContainer->internalnumbers;
	       if (count($internalnumbers)==0)
	       {
	           return;
	       }
	       $this->extensionGroupTable->deleteAllExtensionGroups();
	       
	       $extensionGroupTable = $this->extensionGroupTable;
	       $extensionGroup = new ExtensionGroup();
	       $extensionGroup->name = 'обычные';
	       $extensionGroup->custdesc = 'обычные';
	       $extensionGroup->memberofcallcentreque = 'false';
	       $extensionGroup->extensionrecord = 'undefined';
	       $regularExtensionGroupId = $extensionGroupTable->saveExtensionGroup($extensionGroup);
	
	       $extensionGroupTable = $this->extensionGroupTable;
	       $extensionGroup = new ExtensionGroup();
	       $extensionGroup->name = 'операторы';
	       $extensionGroup->custdesc = 'операторы';
	       $extensionGroup->memberofcallcentreque = 'true';
	       $extensionGroup->extensionrecord = 'active';
	       $operatorExtensionGroupId = $extensionGroupTable->saveExtensionGroup($extensionGroup);
	
	       $this->extensionTable->deleteAllExtensions();
	       
	       foreach ($internalnumbers as $internalnumber)
	       {
	        $extension = clone $this->extension;
	        $extension->exchangeArray($internalnumber->getArrayCopy());
	        $extension->extensiontype=$internalnumber->extensiontype;
	        $extension->diversion_unconditional_status = 'UNDEFINED';
            $extension->diversion_busy_status = 'UNDEFINED';
            $extension->diversion_noanswer_status = 'UNDEFINED';       
            $extension->diversion_unavail_status = 'UNDEFINED';     
	        $extension->email ='';	         
 	        switch ($extension->extensiontype)
	        {
	            case 'operator':
	                $extension->extensiongroup = $operatorExtensionGroupId;
	                break;
	            case 'regular':
	                $extension->extensiongroup = $regularExtensionGroupId;
	                break;
	            default:
	                throw new \Exception('непредвиденная ошибка');
	        }
	        $this->extensionTable->saveExtension($extension);
	       }
	       $this->wizardSessionContainer->wizardActionsCompletedList['process_internal'] = true;
	       
	    }
	    return $this;
	}
	protected function processRoute()
	{
	    $routeStageCompleted = (isset($this->wizardSessionContainer->wizardActionsCompletedList['process_route']))?$this->wizardSessionContainer->wizardActionsCompletedList['process_route']:false;
	    if (!$routeStageCompleted)
	    {
	       $vpbxEnv = $this->wizardSessionContainer->vpbxEnv;
	       $did = $this->wizardSessionContainer->did;
	
	       $didDigigts = ($vpbxEnv && $did)?$did->digits:'';
	
	       $this->numberMatchTable->deleteAllNumberMatches();
	       
	       $numberMatch = new NumberMatch();
	       $numberMatch->custname = 'любой номер (catchall)';
	       $numberMatchId = $this->numberMatchTable->saveNumberMatch($numberMatch);
	
	       
	       $this->regEntryTable->deleteAllRegentries();
	       
	       $regEntry = new RegEntry();
	       $data = array(
	           'numbermatchref'=>$numberMatchId,
	           'regexpression'=> '/[\d]{7,15}/'
	       );
	       $regEntry->exchangeArray($data);
	       $regEntryId = $this->regEntryTable->saveRegEntry($regEntry);
	
	       $this->routeTable->deleteAllRoutes();
	       
	       $route = new Route();
	       $route->custname = 'ТФОП '.$didDigigts;
	       $route->custdesc = '';
	       $route->isdefault = true;
	       $routeId = $this->routeTable->saveRoute($route);
	
           $this->trunkDestinationTable->deleteAllTrunkDestinations();	       
	       $trunkDestination = new TrunkDestination();
	       $data = array(
	           'numbermatchref'=>$numberMatchId,
	           'routeref'=>$routeId,
	           'trunkref'=>$this->trunkId
	
	       );
	       $trunkDestination->exchangeArray($data);
	       $this->trunkDestinationTable->saveTrunkDestination($trunkDestination);
	       $this->wizardSessionContainer->wizardActionsCompletedList['process_route'] = true;	     
	    }
	    return $this;
	}
	protected function processCallCentre()
	{
	    $callCentreStageCompleted = (isset($this->wizardSessionContainer->wizardActionsCompletedList['process_callcentre']))?$this->wizardSessionContainer->wizardActionsCompletedList['process_callcentre']:false;
	    if (!$callCentreStageCompleted)
	    {
	       $callcentreSchedule = new CallCentreSchedule();
	       $callcentreSchedule->exchangeArray(array());
	       $this->callCentreScheduleTable->saveCallCentreSchedule($callcentreSchedule);
	       $this->wizardSessionContainer->wizardActionsCompletedList['process_callcentre'] = true;	       
	    }
	}
	
	protected function markCompletedWizardActionsCompleted()
	{
	    $this->wizardSessionContainer->completed = true;
	}
	protected function getVpbxId()
	{
	    if (!$this->vpbxId)
	    {
	        $this->vpbxId = $this->vpbxidProvider->getVpbxId();
	    }
	    return $this->vpbxId;
	}
}