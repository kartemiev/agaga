<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;
use Zend\Session\Container as SessionContainer;
use Saas\TempMedia\Form\TempMediaForm;
use Zend\View\Model\JsonModel;

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
		$viewModel->addChild($pickdid, 'window');						 
		return $viewModel;
	}
	public function step2Action()
	{ 	 
		$uploadMedia = $this->forward()->dispatch('Saas\Controller\UploadMedia', array('action' => 'index'));
		$viewModel = new ViewModel();
		if ($uploadMedia instanceof Response)
		{
			return $uploadMedia;
		}
		$viewModel->addChild($uploadMedia, 'window');
		return $viewModel;
	}
	public function step3Action()
	{
		$createinternal = $this->forward()->dispatch('Saas\Controller\CreateInternal', array('action' => 'index'));
		$viewModel = new ViewModel();
		if ($createinternal instanceof Response)
		{
			return $createinternal;
		}
		$viewModel->addChild($createinternal, 'window');
		return $viewModel;
	}
	
}