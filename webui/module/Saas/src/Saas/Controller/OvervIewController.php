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
		return new ViewModel();
	}
}