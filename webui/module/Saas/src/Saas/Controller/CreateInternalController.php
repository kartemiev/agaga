<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container as SessionContainer;
use Saas\CreateInternal\Form\CreateInternalForm;
use Saas\CreateInternal\Form\NumbersAllowedForm;
use Saas\CreateInternal\Model\ExtensionHydrator;
use Vpbxui\Extension\Model\Extension;
use Saas\CreateInternal\Model\CreateInternalInputFilterFactory;
use Vpbxui\Extension\Form\ExtensionForm;
class CreateInternalController extends AbstractActionController
{
	public $wizardSessionContainer;
	public $extension;
	public $extensionForm;
	public function __construct(SessionContainer $wizardSessionContainer, Extension $extension, ExtensionForm $extensionForm)
	{
		$this->wizardSessionContainer = $wizardSessionContainer;
		$this->extension = $extension;
		$this->extensionForm = $extensionForm;
	}
	public function indexAction()
	{
		$regularinternallistForm = new CreateInternalForm();
		$regularinternallistForm->setAttribute('id', 'regularinternallist');
		$regularinternallistForm->get('number')->setAttribute('id', 'regularinternallistselect');
		$ccoperatorlistForm = new CreateInternalForm();
		$ccoperatorlistForm->setAttribute('id', 'ccoperatorlist');
		$ccoperatorlistForm->get('number')->setAttribute('id', 'ccoperatorselect');
		
		$numbersAllowedForm = new NumbersAllowedForm();		
		$numbersAllowedForm->get('chk_group')->setValue("300");
		
 		return new ViewModel(
 				array(
 						'regularinternallistform'=>$regularinternallistForm,
 						'ccoperatorlistform'=>$ccoperatorlistForm,
 						'numbersallowedform'=>$numbersAllowedForm
 			)
 		);
	}
	
	public function submitAction()
	{		
		$request  = $this->getRequest();
		$response = $this->getResponse();		
		$data = \Zend\Json\Json::decode($request->getContent(),\Zend\Json\Json::TYPE_ARRAY);
		$extensiontypemap = array('regularinternallist'=>'regular','ccoperatorlist'=>'operator');
	 
		$internalnumbers = array();
		
		foreach ($data as $name=>$selection)
		{
			if (!array_key_exists($name,$extensiontypemap))
			{
				continue;
			}
 					foreach ($selection as $entry)
					{
						$inputFilter = CreateInternalInputFilterFactory::getInstance();						
 						$extension = new Extension();
 						$extension->setInputFilter($inputFilter);
  						$form = clone $this->extensionForm;
						$form->setHydrator(new ExtensionHydrator());	
						$form->setInputFilter($inputFilter);	
 						$data = array(
							'extension'=>$entry['id'],
							'custname'=>$entry['text']	
						);	
						$form->setData($data);
						$form->bind($extension);
						
 						if (!$form->isValid())
						{
							var_dump($form->getMessages());
							return new \Zend\Http\Response(\Zend\Http\Response::STATUS_CODE_400);
						}
						$extension->extensiontype = $extensiontypemap[$name];					 
						$internalnumbers[]=$extension;
					}
		}
		$this->wizardSessionContainer->internalnumbers = $internalnumbers;
 		return new JsonModel();
	}
}