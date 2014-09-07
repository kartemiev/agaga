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
			CallCentreScheduleTableInterface $callCentreScheduleTable
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
	}
	public function create($data)
	{
	
	    $this->processVpbxEnv();
	    $this->processMedia(); 	    
	    $this->processTrunksAndContext();
	    
	    return new JsonModel();
	     
	    
	    $this->processInternal();
	    $this->processRoute();
	    $this->processCallCentre();
	
	}
	protected function processMedia()
	{
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
 	     
	    return $this;
	}
	protected function processVpbxEnv()
	{
	    $vpbxEnv = $this->wizardSessionContainer->vpbxEnv;
	    $vpbxEnv->vpbx_name = 'виртульная АТС для тестов';
	    $vpbxEnv->vpbx_description = 'виртульная АТС для тестов';
	    $vpbxEnv->vpbx_remotevpbxid = (string)$this->getVpbxId();
	    
	    if ($vpbxEnv)
	    {
	        $this->vpbxEnv = $this->vpbxEnvTable->saveVpbxEnv($vpbxEnv);
	    }	    
	      
	    return $this;
	}
	protected function processTrunksAndContext()
	{
	    $vpbxEnv = $this->vpbxEnv;
	    $trunk = new Trunk();
	
	    $trunk->name = $vpbxEnv->sip_name;
	    $trunk->secret = $vpbxEnv->sip_secret;
	    $trunk->host = 'serv-02';
	    $trunk->callbackextension = $vpbxEnv->sip_name;
	    $trunk->context = 'vpbx_dialout';

	    $trunkId = $this->trunkTable->saveTrunk($trunk);
	    $this->trunkId  = $trunkId;

	    $ivr = new Ivr();
	    $ivr->custname = 'основной';
	    $ivr->custdesc = 'основной';
	    $ivrId = $this->ivrTable->saveIvr($ivr);
	    
	    $context = clone $this->context;
	    $data = array(
	        'custname' => 'основной',
	        'custdesc' => 'основной',
	        'contexttype' => 'IVR',
	        'ivrref'=>$ivrId
	    );
	    $context->exchangeArray($data);
	    $contextId = $this->contextTable->saveContext($context);
	
	    $trunkAssoc = new TrunkAssoc();
	    $data = array(
	        'trunkref'=>$trunkId,
	        'contextref'=>$contextId
	    );
	    $trunkAssoc->exchangeArray($data);
	    $this->trunkAssocTable->saveTrunkAssoc($trunkAssoc);
	    $this->getResponse()->setStatusCode(201);
	     
	    return $this;
	}
	protected function processInternal()
	{
	    $internalnumbers = $this->wizardSessionContainer->internalnumbers;
	    if (count($internalnumbers)==0)
	    {
	        return;
	    }
	    $vpbxid = $this->getVpbxId();
	    $extensionGroupTable = $this->extensionGroupTable;
	    $extensionGroup = new ExtensionGroup();
	    $extensionGroup->name = 'обычные';
	    $extensionGroup->custdesc = 'обычные';
	    $extensionGroup->memberofcallcentreque = 'false';
	    $extensionGroup->extensionrecord = 'false';
	    $extensionGroup->vpbxid = $vpbxid;
	    $regularExtensionGroupId = $extensionGroupTable->saveExtensionGroup($extensionGroup);
	
	    $extensionGroupTable = $this->extensionGroupTable;
	    $extensionGroup = new ExtensionGroup();
	    $extensionGroup->name = 'обычные';
	    $extensionGroup->custdesc = 'обычные';
	    $extensionGroup->memberofcallcentreque = 'true';
	    $extensionGroup->extensionrecord = 'true';
	    $extensionGroup->vpbxid = $vpbxid;
	    $operatorExtensionGroupId = $extensionGroupTable->saveExtensionGroup($extensionGroup);
	
	    	
	    foreach ($internalnumbers as $internalnumber)
	    {
	        $extension = clone $this->extension;
	        $extension->exchangeArray($internalnumber->getArrayCopy());
	        $extension->vpbxid = $vpbxid;
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
	    return $this;
	}
	protected function processRoute()
	{
	    $vpbxEnv = $this->wizardSessionContainer->vpbxEnv;
	    $did = $this->wizardSessionContainer->did;
	
	    $didDigigts = ($vpbxEnv && $did)?$did->digits:'';
	
	    $numberMatch = new NumberMatch();
	    $numberMatch->custname = 'любой номер (catchall)';
	    $numberMatchId = $this->numberMatchTable->saveNumberMatch($numberMatch);
	
	    $regEntry = new RegEntry();
	    $data = array(
	        'numbermatchref'=>$numberMatchId,
	        'regexpression'=> '/[\d]{7,15}/'
	    );
	    $regEntry->exchangeArray($data);
	    $regEntryId = $this->regEntryTable->saveRegEntry($regEntry);
	
	    $route = new Route();
	    $route->custname = 'ТФОП '.$didDigigts;
	    $route->custdesc = '';
	    $route->isdefault = true;
	    $routeId = $this->routeTable->saveRoute($route);
	
	    $trunkDestination = new TrunkDestination();
	    $data = array(
	        'numbermatchref'=>$numberMatchId,
	        'routeref'=>$routeId,
	        'trunkref'=>$this->trunkId
	
	    );
	    $this->trunkDestinationTable->saveTrunkDestination($trunkDestination);
	    return $this;
	}
	protected function processCallCentre()
	{
	    $callcentreSchedule = new CallCentreSchedule();
	    $this->callCentreScheduleTable->saveCallCentreSchedule($callcentreSchedule);
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