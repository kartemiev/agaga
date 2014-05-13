<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Service\ClientImpl\ClientImplInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Exception\ChannelDownException;
use PbxAgi\Service\RouteBuilder\RouteBuilder;
use PbxAgi\Service\SkypeAliasResolver\SkypeAliasResolver;
use PbxAgi\DialDescriptor\DialOptionsDescriptor;
use PbxAgi\Service\ChannelVarManager\ChannelVarManager;
 
class PstnController extends AbstractActionController {
    
    protected $routeBuilder;
    protected $agi;
    protected $appConfig;
    protected $trunks;
    protected $call;
    protected $numType; 
    protected $skypeAliasResolver;
    protected $dialOptionsDescriptor;
    protected $varManager;
    public function __construct(
            RouteBuilder $routeBuilder, 
            $agi,
            AppConfigInterface $appConfig,
    		SkypeAliasResolver $skypeAliasResolver,
    		DialOptionsDescriptor $dialOptionsDescriptor,
    		ChannelVarManager $varManager    		
 			) {
        $this->routeBuilder = $routeBuilder;
        $this->agi = $agi;
        $this->appConfig = $appConfig;
        $this->skypeAliasResolver = $skypeAliasResolver;
        $this->dialOptionsDescriptor = $dialOptionsDescriptor;
        $this->varManager = $varManager;
     }
 
    protected function run($trunks)
    {
    	$extension = $this->call->getExten();
    	if (AppConfigInterface::ASTERISK_DIALED_NUM_TYPE_SKYPE == $this->getNumType())
    	{
    	    $extension = $this->skypeAliasResolver->resolve($extension);
    	    if (!$extension) 
    	    {
    	        return null;
    	    }
    	}
    	
 		$this->setupBasicDialOptions();    	
 		    	
             foreach ($trunks as $trunk)
            { 
                 $peername = $trunk->name;
                 $duration = 60;
                 $technology = 'SIP';
                $callerid = $trunk->callerid;
                if (isset($callerid)&&(NULL!==$callerid))
                {
                    $this->agi->setCallerId($callerid, $callerid);
                } 
                $dialString = implode('/', array($technology, $peername, $extension));
                
                $result = $this->agi->dial($dialString,
                            array( $duration, $this->dialOptionsDescriptor->__toString())
                        );                
                if ($result->isAnswer()) 
                {
                	break;                
                }
            } 
       return $result;        
    }
        public function indexAction() { 
        	
        	$call = $this->PrepareCallControllerPlugin()
        			     ->initCall();
        	$this->call = $call;
        	 
        	$dialoutPstnPermission  = 
        	$this->FeatureCheckPermissionPlugin('outgoingcallspermission',array('allowed','undefined'));
            if ($dialoutPstnPermission){
                try {
                $routeBuilder = $this->routeBuilder;
                 $routeBuilder->setNumber($call->getExten());
                $routeBuilder->setId(
                			$call->getCallOriginator()->getRouteref()
                		);
                 $routeBuilder->create();                
                 
                $trunkDestinations = $routeBuilder->getDestinations();
	    
                 $result = $this->run($trunkDestinations);
                return $result;
                } catch (ChannelDownException $e)
                {
                }
            }
            else 
            {
                $this->bounceCall();
            }
       } 
       public function hangupAction()
    {
        
    }
    protected function bounceCall()
    {
        $agi = $this->agi;
        $agi->hangup(AppConfigInterface::AST_HANGUPCAUSE_OUTGOING_CALL_BARRED);
    }
    protected function getNumType()
    {
    	if (!$this->numType)
    	{
       	 $extension = $this->call->getExten();
       	 $numtype = (AppConfigInterface::ASTERISK_SKYPE_ALIAS_NUMBER_LENGTH == strlen($extension))? 
        	AppConfigInterface::ASTERISK_DIALED_NUM_TYPE_SKYPE:
        	AppConfigInterface::ASTERISK_DIALED_NUM_TYPE_PSTN;
        	$this->numType = $numtype;
    	}
    	return $this->numType;
    }      
    protected function setupBasicDialOptions()
    {
    	$dialOptions = $this->dialOptionsDescriptor;
    	$dialOptions->getAllowCallingCallPark()
    				->enable();
    	$dialOptions->getExecuteMacro()
    				->enable()
    				->setMacroName('callrecord');
    	
    	$callerTransferPermission = $this->varManager
    									 ->getCallerTransferPermission();
     	 
    	if ($callerTransferPermission){
    		$dialOptions->getAllowCallerTransfer()->enable();    		    		
     	}
    	      	
    	
    	$dialOptions->getAllowCallerAutomon()->enable();    	 
    }
}
  