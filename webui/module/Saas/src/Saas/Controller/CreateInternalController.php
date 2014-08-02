<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class CreateInternalController extends AbstractActionController
{
	public function indexAction()
	{
		return new ViewModel();
	}
}