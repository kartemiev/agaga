<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;
use Zend\Session\Container as SessionContainer;

class VpbxWizardController extends AbstractActionController
{
	protected $wizardSessionContainer;
	public function __construct(SessionContainer $wizardSessionContainer)
	{
		$this->wizardSessionContainer = $wizardSessionContainer;	
	}
	public function indexAction()
	{
		return new ViewModel();
	}
	public function step1Action()
	{
		$pickdid = $this->forward()->dispatch('Saas\Controller\PickDid', array('action' => 'index'));
		$viewModel = new ViewModel();
		if ($pickdid instanceof Response)
		{
			return $pickdid;
		}
		else 
		{
			$viewModel->addChild($pickdid, 'window');				
		}
		return $viewModel;
	}
	public function step2Action()
	{
 	 
		return new ViewModel(array('flashMessages'=>$this->flashMessenger()->getMessages()));
	}
	public function step3Action()
	{
	
	}
	
}