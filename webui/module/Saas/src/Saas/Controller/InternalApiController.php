<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Session\Container as SessionContainer;
use Vpbxui\Extension\Model\Extension;
use Vpbxui\Extension\Form\ExtensionForm;
use Zend\View\Model\JsonModel;
use Saas\CreateInternal\Model\CreateInternalInputFilterFactory;
use Saas\CreateInternal\Model\ExtensionHydrator;


class InternalApiController extends AbstractRestfulController
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
	public function getList()
	{
		$internalnumbers = (isset($this->wizardSessionContainer->internalnumbers))?$this->wizardSessionContainer->internalnumbers:array();

		$regularinternallist = array();
		$ccoperatorlist = array();
		$hydrator = new ExtensionHydrator();
	
		foreach ($internalnumbers as $internalnumber)
 				
		{
			switch ($internalnumber->extensiontype)
			{
				case 'regular':
					$regularinternallist[] = $hydrator->extract($internalnumber);			 
					break;
				case 'operator':
					$ccoperatorlist[] = $hydrator->extract($internalnumber);
					break;
			}
		}
	 
		return new JsonModel(
				array(
						'regularinternallist' => $regularinternallist,
						'ccoperatorlist' => $ccoperatorlist
			)
		);
		
	}
	public function patchList($data)
	{
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
					return new \Zend\Http\Response(\Zend\Http\Response::STATUS_CODE_400);
				}
				$extension->extensiontype = $extensiontypemap[$name];
				$internalnumbers[]=$extension;
			}
		}
		$this->wizardSessionContainer->internalnumbers = $internalnumbers;
		return new JsonModel(array('data'=>$internalnumbers));
	}
}