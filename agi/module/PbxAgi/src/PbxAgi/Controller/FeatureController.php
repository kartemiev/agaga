<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PAGI\Client\IClient;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;
use PbxAgi\Feature\Model\FeatureTable;

class FeatureController extends AbstractActionController
{
 	protected $appConfig;
	protected $varManager;
	protected $featureTable;
	
	protected $featuresDispatchMap = array(
	    	1 => array('name'=>'JoinConference',
	    				'controller'=>'ConferenceController',
	    				'action'=>'join'
	    			)
		);
	
	public function __construct(
			AppConfigInterface $appConfig,
 			ChannelVarManagerInterface $varManager,
			FeatureTable $featureTable
	)
	{
		$this->appConfig = $appConfig;
 		$this->varManager = $varManager;
		$this->featureTable = $featureTable;
	}
	public function indexAction()
	{
	    $featureId = $this->varManager->getExten();	 
	    
	    
	    $featuresDispatchMap = $this->featuresDispatchMap;
	    
	    if (!isset($featuresDispatchMap[$featureId]))
	    {
	        throw new \Exception('Unrecognized feature requested');
	    }
	    
 	    $featureMapEntry = $featuresDispatchMap[$featureId];
 	     	    
	    $controller = $featureMapEntry['controller'];
	    $action = $featureMapEntry['action'];
	    
	    $namespace = __NAMESPACE__;	     
	    
	    $result = $this->forward()
	    				->dispatch(implode('\\',array($namespace,$controller)),
	    		array_merge(array('action' => $action), array()));	     
	    
	}
	public function hangupAction()
	{
	    
	}
}