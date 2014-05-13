<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CallCentreSettingsController extends AbstractActionController
{
	public function indexAction()
	{
		
   		$viewModel = new ViewModel(         	 
   				array('flashMessages' => $this->flashMessenger()->getMessages())         		     
   		);
     	$viewModel->setTemplate('vpbxui/empty/empty.phtml');
     	return $viewModel;      	
	}	
}