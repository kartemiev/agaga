<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Saas\TempMedia\Form\TempMediaForm;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class UploadMediaController extends AbstractActionController
{
	public function indexAction()
	{
		$form = new TempMediaForm();
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$post = array_merge_recursive(
					$request->getPost()->toArray(),
					$request->getFiles()->toArray()
			);
		
			$file =  reset($request->getFiles());
		
			$data = array('file'=>array('name'=>$file['name']));
			return new JsonModel($data);
		}
		
		return new ViewModel(array(
				'flashMessages'=>$this->flashMessenger()->getMessages(),
				'form'=>$form
		));
	}
}