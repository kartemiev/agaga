<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Saas\TempMedia\Form\TempMediaForm;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as SessionContainer;
use Saas\TempMedia\Model\TempMediaTableInterface;
use Saas\TempMedia\Model\TempMedia;
use PAGI\CallSpool\Impl\rename;
use Saas\Service\AppConfig\AppConfigInterface;

class UploadMediaController extends AbstractActionController
{
	protected $wizardSessionContainer;
	protected $tempMediaTable;
	protected $appConfig;
 	public function __construct(SessionContainer $wizardSessionContainer, TempMediaTableInterface $tempMediaTable, AppConfigInterface $appConfig)
	{
		$this->wizardSessionContainer = $wizardSessionContainer;
		$this->tempMediaTable = $tempMediaTable;
		$this->appConfig = $appConfig;
	}
	public function indexAction()
	{
 		$form = new TempMediaForm();
		
		$wizardSessionContainer = $this->wizardSessionContainer;
		$tempMediaTable = $this->tempMediaTable;
		
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
 			$tempMedia = new TempMedia();
			$tempMedia->custname = $filedata['name'];
			$tempMedia->filesize = $filedata['size'];
			$tempMedia->contenttype = $filedata['type'];
			$mediatypeMapper = array(
			    'wtgreeting'=>'greeting',
			    'wegreeting'=>'greetingofftime',
			    'mohtone'=>'musiconhold',
			    'ringingbacktone'=>'ringingtone'
			);
			$tempMedia->mediatype = $mediatypeMapper[$name];		
			$id = $tempMediaTable->saveTempMedia($tempMedia);
			rename($filedata['tmp_name'],$this->appConfig->getTempMediaPath().'/'.$id);	
			$tempMedia->id = $id;			
			$wizardSessionContainer->media[$name] = $tempMedia;
			$data = array('file'=>array('id'=>$id,'name'=>$filedata['name']));
				
			return new JsonModel($data);
		}
		return new ViewModel(array(
				'flashMessages'=>$this->flashMessenger()->getMessages(),
				'form'=>$form,
				'media'=>$media
		));
	}
	 
}