<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PAGI\Exception\ChannelDownException;
use PAGI\Node\Node;
use PAGI\Node\NodeController;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Client\IClient;
use PbxAgi\Validator\Extension\ExtensionRegexValidatorInterface;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\DialDescriptor\DialOptionsDescriptor;
use PbxAgi\Service\AppConfig\AppConfigService;
   
class DialInController extends AbstractActionController
{
    public $nodeController;
    public $agi;
    public $appConfig;
    protected $extensionValidator;
    protected $varManager;
	protected $dialOptions;
    
    public function __construct(
            AppConfigInterface $appConfig, 
            IClient $agi, 
            ExtensionRegexValidatorInterface $extensionValidator,
            ChannelVarManagerInterface $varManager,
    		DialOptionsDescriptor $dialOptions
             )
    {
    	$this->appConfig = $appConfig;
    	$this->agi = $agi;
        $this->extensionValidator = $extensionValidator;
        $this->varManager = $varManager;
        $this->dialOptions = $dialOptions;
    }
    protected function buildGenericNode($name, NodeController $nodeController)
    {
        $totalMaxInput = 
        ($this->TimeControllerPlugin()->isWorkingHours())?
       4000:
        $this->appConfig
             ->getIncomingPstnMenuInputTotalMaxOfftime();
        
        return $nodeController->register($name)
            ->maxTotalTimeForInput( $totalMaxInput )
            ->maxTimeBetweenDigits(
                $totalMaxInput
                )
        ;
    }   
    
    public function conferenceJoinValidator(Node $node)
    {
        return in_array($node->getInput(),array('*90'));
    }
    public function extensionValidator(Node $node)
    {    
       return $this->extensionValidator->isValid($node->getInput()); 
    }   
    
    public function menuEntryValidator(Node $node)
    {
    	$mapentries = $this->getMenuFunctionCallbackMap();
    	foreach ($mapentries as $mapentry)
    	{
    		if (call_user_func($mapentry['validator'],$node))
    		{
    			return true;
    		}
    	}
    	return false;
    }
    public function callExtension(Node $node)
    {
        $extenNum = $node->getInput();
        $this->PrepareCallControllerPlugin()->setCallDestinator($extenNum);
        $this->agi->dial(
            'Local/'.$extenNum."@".$this->appConfig->getDialSipExtensionContextName()."/n"
            );
      }
    public function callConferenceJoin(Node $node)
    {    	
    	$this->forward()->dispatch(implode('\\',array(__NAMESPACE__,'ConferenceController')), 
                   array_merge(array('action' => 'join')));
    }
    public function getMenuFunctionCallbackMap()
    {
        return array(
        		'extension'=>
        		array('validator'=>array($this,'extensionValidator'),'callback'=>array($this, 'callExtension')),
        		'conferencejoin'=>
        		array('validator'=>array($this,'conferenceJoinValidator'),'callback'=>array($this, 'callConferenceJoin'))
        );
    }
    public function processMenuEntry(Node $node)
    {
        $mapentries = $this->getMenuFunctionCallbackMap();
        foreach ($mapentries as $mapentry)
        {
            if (call_user_func($mapentry['validator'],$node))
            {
            	call_user_func($mapentry['callback'],$node);
                break;
             }
        }         
    }
    
    
    public function onInvalidNumberEntered(Node $node)
    {
       return $node->getClient()
               ->hangup();                 
    }    
     
    protected function getCurrentGreeting()
    {
        return ($this->TimeControllerPlugin()->isWorkingHours())?
            $this->appConfig->getBusinessHoursGreeting(): 
            $this->appConfig->getOffTimeGreeting(); 
    }
    public function callCallCentre(Node $node)
    {
        
        if ($this->TimeControllerPlugin()->isWorkingHours()){
             $callcentrecontext = $this->appConfig->getCallCentreContextName();
            $dialString = "Local/run@{$callcentrecontext}/n";
            $dialOptions = $this->dialOptions;           
            $dialOptions->getRingingMoh()
            			->enable()
            			->setMohClass(AppConfigService::RINGBACK_MOH_CLASS);

            
            $this->agi->dial($dialString, array(NULL, $dialOptions->__toString()));
        };
            
            $this->agi->hangup();            
     }
    protected function buildMainMenu(NodeController $nodeController)
    {
        $closurize = $this->ClosurizePlugin();
  
        $this->buildGenericNode('mainMenu', $nodeController)
             ->saySound('silence/1')
             ->saySound($this->getCurrentGreeting())
              ->expectAtLeast(1)
            ->expectAtMost(3)
            ->maxAttemptsForInput(1) 
             ->validateInputWith(
                'option',
                $closurize->closurize(
                        array($this,'menuEntryValidator')
                        ),
                'pbx-invalid'  
            )
           ->executeOnValidInput (
                 $closurize->closurize(
                         array($this,'processMenuEntry')
                         )
                   )
           ->executeAfterFailedValidation (
                 $closurize->closurize(
                         array($this,'onInvalidNumberEntered')
                         )
                   )                  
        ;
        
         $nodeController->registerResult('mainMenu')
            ->onMaxAttemptsReached()
             ->execute(
                  $closurize->closurize(array($this,'callCallCentre'))                 
                 );
        ;                    
                            
    }
    
     public function proceed()
    {
       try {
       		       	
           $this->agi->answer();
       	   $this->nodeController->jumpTo('mainMenu');
         } catch (ChannelDownException $e){};
    }

    public function indexAction()
    {
   
       $this->nodeController = $this->agi->createNodeController('app');
       $this->TransferControllerPlugin();
       $this->buildMainMenu($this->nodeController);        
        $this->proceed();

     }
     public function hangupAction()
    {
        
    }
    
    protected function prepareChannelVars($call)
    {
        $this->varManager->setupOutgoingCall($call);
    }
    
    protected function init()
    {
        $this->redirector = $this->RedirectorControllerPlugin();
        $this->call = $this
        ->PrepareCallControllerPlugin()
        ->initCall();
        $this->prepareChannelVars($this->call);
    }
    
     
 }
