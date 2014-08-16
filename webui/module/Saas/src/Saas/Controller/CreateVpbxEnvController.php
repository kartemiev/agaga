<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container as SessionContainer;
use Vpbxui\Extension\Model\ExtensionTableInterface;
use Saas\VpbxEnv\Model\VpbxEnvTableInterface;
use Vpbxui\MediaRepos\Model\MediaReposTableInterface;
use Vpbxui\GeneralSettings\Model\GeneralSettingsTable;
use Vpbxui\MediaRepos\Model\MediaRepos;
use Zend\Stdlib\Hydrator\ObjectProperty;
use PAGI\CallSpool\Impl\rename;
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
 
class CreateVpbxEnvController extends AbstractActionController
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
			SessionContainer $wizardSessionContainer, 
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
	}
	public function indexAction()
	{
 
			$this->processVpbxEnv();
			$this->processMedia();
			$this->processTrunksAndContext();
			$this->processInternal();
			$this->processRoute();
			$this->processCallCentre();
	 
	}
	protected function processMedia()
	{
		$media = (isset($this->wizardSessionContainer->media)) ?$this->wizardSessionContainer->media:null;
		$hydrator = new ObjectProperty();
		$mediatypeMapper = array(
				'wtgreeting'=>'greeting', 
				'wegreeting'=>'greetingofftime', 
				'mohtone'=>'musiconhold', 
				'ringingbacktone'=>'ringingtone'
		);
		$generalSettingsTable = $this->generalSettingsTable;
		$vpbxId = $this->getVpbxId();
		$generalSettings = $this->generalSettingsTable->getSettings($vpbxId);		
		if ($media)
		{
			foreach ($media as $type => $tmpMedia)
			{
				$mediaRepos = new MediaRepos();
				$data = $hydrator->extract($tmpMedia);
				$hydrator->hydrate($mediaRepos,$data);
				$mediaRepos->mediatype = 'ANYMEDIA';
				$mediaRepos->vpbxid = $this->vpbxId;
				$id = $this->mediaReposTable->saveMediaRepos($mediaRepos);
				rename(UploadMediaController::TMP_MEDIA_PATH.'/'.$tmpMedia->id, MediaReposController::VPBX_MEDIAREPOSDIR.'/'.$id);
				if (!array_key_exists($type,$mediatypeMapper))
				{
					continue;
				}
				$generalSettings->$mediatypeMapper[$type] = $id;
 			}
 			$generalSettingsTable->saveSettings($generalSettings);
		}
		return $this;
	}
	protected function processVpbxEnv()
	{
		$vpbxEnv = ($this->wizardSessionContainer->vpbxEnv)?$this->wizardSessionContainer->vpbxEnv:null;
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
		
		$data = array(
			'name'=>$vpbxEnv->sip_name,
			'secret'=>$vpbxEnv->sip_secret,
			'host'=>'serv-02',
			'callbackexten'=>$vpbxEnv->sip_name,
			'context'=>'vpbx_dialout'		
		);
		$trunk->exchangeArray($data);
		$trunkId = $this->trunkTable->saveTrunk($trunk);
		$this->trunkId  = $trunkId;
		$ivr = new Ivr();
		$data = array(
			'custname' => 'основной',
			'custdesc' => 'основной'	
		);
		$ivr->exchangeArray($data);
		$ivrId = $this->ivrTable->saveIvr($ivr);		
		
		$contextId = $context = clone $this->context;
		$data = array(
			'custname' => 'основной',
			'custdesc' => 'основной',
			'contexttype' => 'IVR',
			'ivrref'=>$ivrId	
		);
		$this->contextTable->saveContext($context);
		
		$trunkAssoc = new TrunkAssoc();
		$data = array(
				'trunkref'=>$trunkId,
				'contextref'=>$contextId
		);
		$trunkAssoc->exchangeArray($data);
		$this->trunkAssocTable->saveTrunkAssoc($trunkAssoc);
 		return $this;
	}
	protected function processInternal()
	{
		$internalnumbers = (isset($this->wizardSessionContainer->internalnumbers))?$this->wizardSessionContainer->internalnumbers:array();
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
		$vpbxEnv = (isset($this->wizardSessionContainer->vpbxEnv))?$this->wizardSessionContainer->vpbxEnv:null;
		$did = (isset($this->wizardSessionContainer->did))?$this->wizardSessionContainer->did:null;
		
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