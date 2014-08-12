<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container as SessionContainer;
use Zend\View\Model\ViewModel;

class OverviewController extends AbstractActionController
{
 
	protected $wizardSessionContainer;
	public function __construct(SessionContainer $wizardSessionContainer)
	{
		$this->wizardSessionContainer = $wizardSessionContainer;	
	}
	public function indexAction()
	{
 
		$wizardSessionContainer = $this->wizardSessionContainer;
		$internalnumbers = (isset($wizardSessionContainer->internalnumbers))?$wizardSessionContainer->internalnumbers:array();
		$vpbxEnv = (isset($wizardSessionContainer->vpbxEnv))?$wizardSessionContainer->vpbxEnv:null;	
		$media = (isset($wizardSessionContainer->media))?$wizardSessionContainer->media:null;
		$did = (isset($wizardSessionContainer->did))?$wizardSessionContainer->did:null;
		
	 
		
		
 		return new ViewModel(
				array(
						'internalnumbers'=>$internalnumbers,
						'vpbxEnv'=>$vpbxEnv,
						'media'=>$media,
						'did'=>$did
				)
		);
	 
 	}
}