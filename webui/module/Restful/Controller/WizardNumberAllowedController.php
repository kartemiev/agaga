<?php
namespace Restful\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Saas\CreateInternal\Form\NumbersAllowedForm;

class WizardNumberAllowedController extends AbstractRestfulController
{
	public function patchList($data)
	{
		$form = new NumbersAllowedForm();
		$form->setData($data);
		$form->bind($object);
	}
}