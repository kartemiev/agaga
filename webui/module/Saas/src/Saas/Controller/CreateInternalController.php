<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Saas\CreateInternal\Form\CreateInternalForm;
use Saas\NumberAllowed\Form\NumberAllowedForm;
use Saas\CreateInternal\Model\CreateInternalInputFilterFactory;

class CreateInternalController extends AbstractActionController
{
	public function indexAction()
	{
		$regularinternallistForm = new CreateInternalForm();
		$regularinternallistForm->setAttribute('id', 'regularinternallist');
		$regularinternallistForm->get('number')->setAttribute('id', 'regularinternallistselect');
		$ccoperatorlistForm = new CreateInternalForm();
		$ccoperatorlistForm->setAttribute('id', 'ccoperatorlist');
		$ccoperatorlistForm->get('number')->setAttribute('id', 'ccoperatorselect');
		
		$numbersAllowedForm = new NumberAllowedForm();		
		$numbersAllowedForm->get('chk_group')->setValue("300");
		
 		return new ViewModel(
 				array(
 						'regularinternallistform'=>$regularinternallistForm,
 						'ccoperatorlistform'=>$ccoperatorlistForm,
 						'numbersallowedform'=>$numbersAllowedForm
 				)
 			);
	}
}