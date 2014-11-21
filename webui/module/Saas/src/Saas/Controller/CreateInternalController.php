<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Saas\CreateInternal\Form\CreateInternalForm;
use Saas\NumberAllowed\Form\NumberAllowedForm;
use Saas\CreateInternal\Model\CreateInternalInputFilterFactory;
use Saas\WizardSessionContainer\WizardSessionContainer as SessionContainer;

class CreateInternalController extends AbstractActionController
{
    private $wizardSessionContainer;
    public function __construct(SessionContainer $wizardSessionContainer)
    {
        $this->wizardSessionContainer = $wizardSessionContainer;
    }
	public function indexAction()
	{
		$regularinternallistForm = new CreateInternalForm();
		$regularinternallistForm->setAttribute('id', 'regularinternallist');
		$regularinternallistForm->get('number')->setAttribute('id', 'regularinternallistselect');
		$ccoperatorlistForm = new CreateInternalForm();
		$ccoperatorlistForm->setAttribute('id', 'ccoperatorlist');
		$ccoperatorlistForm->get('number')->setAttribute('id', 'ccoperatorselect');
		
		$numbersAllowedForm = new NumberAllowedForm();		
		$url = $this->url()->fromRoute('numberallowed');		
		$numbersAllowedForm->setAttribute('action', $url);		
		$chkGroupElement = $numbersAllowedForm->get('chk_group');
 		$chkGroupElement->setValue($this->wizardSessionContainer->numberAllowed->getArrayCopy());
		
 		return new ViewModel(
 				array(
 						'regularinternallistform'=>$regularinternallistForm,
 						'ccoperatorlistform'=>$ccoperatorlistForm,
 						'numbersallowedform'=>$numbersAllowedForm
 				)
 			);
	}
}