<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Saas\WizardSessionContainer\WizardSessionContainerInterface;

class OverviewController extends AbstractActionController
{
 
	protected $wizardSessionContainer;
	public function __construct(WizardSessionContainerInterface $wizardSessionContainer)
	{
		$this->wizardSessionContainer = $wizardSessionContainer;	
	}
	public function indexAction()
	{
 
		$wizardSessionContainer = $this->wizardSessionContainer;
		$internalnumbers = (isset($wizardSessionContainer->internalnumbers))?$wizardSessionContainer->internalnumbers:array();
		$vpbxEnv = (isset($wizardSessionContainer->vpbxEnv))?$wizardSessionContainer->vpbxEnv:null;	
		$media = (isset($wizardSessionContainer->media))?$wizardSessionContainer->media:null;
		$did = $wizardSessionContainer->did;
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