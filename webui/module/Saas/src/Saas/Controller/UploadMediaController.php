<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Saas\TempMedia\Form\TempMediaForm;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as SessionContainer;

class UploadMediaController extends AbstractActionController
{
	protected $wizardSessionContainer;
	public function __construct(SessionContainer $wizardSessionContainer)
	{
		$this->wizardSessionContainer = $wizardSessionContainer;
	}
	public function indexAction()
	{
		$form = new TempMediaForm();
		
		$wizardSessionContainer = $this->wizardSessionContainer;
		
		if (!isset($wizardSessionContainer->media))
		{
			$wizardSessionContainer->media = array();
		}
		$media = $wizardSessionContainer->media;
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
	
			$file =  array_slice($request->getFiles()->toArray(),0,1);
			$filedata = array_shift(array_values($file));
			$name = key($file);
			$wizardSessionContainer->media[$name] = $filedata;
			$data = array('file'=>array('name'=>$filedata['name']));
			return new JsonModel($data);
		}
		
		return new ViewModel(array(
				'flashMessages'=>$this->flashMessenger()->getMessages(),
				'form'=>$form,
				'media'=>$media
		));
	}
}