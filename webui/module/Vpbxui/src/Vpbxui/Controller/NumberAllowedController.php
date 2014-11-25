<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Vpbxui\NumberAllowed\Model\NumberRangeTable;
use Vpbxui\NumberAllowed\Model\NumberRange;
use Vpbxui\NumberAllowed\Form\NumberAllowedForm;
use Zend\Form\Element\Submit;

class NumberAllowedController extends AbstractActionController
{
    private $numberRangeTable;
    public function __construct(NumberRangeTable $numberRangeTable)
    {
        $this->numberRangeTable = $numberRangeTable;
    }
    public function indexAction()    
    {
        $request = $this->getRequest();
        $numberRange = new NumberRange();
        $form = new NumberAllowedForm();
        
        $form->setAttribute('method', 'post');
        $form->setAttribute('enctype', 'application/x-www-form-urlencoded');
        $element = new Submit('submit');
        $element->setAttributes(array(
                    'type'  => 'submit',
                    'value' => 'Сохранить',
                    'id' => 'submitbutton')
                );
        
        $form->add($element);
         
        if ($request->isPost()) {
            $inputFilter = $numberRange->getInputFilter();
         			$form->setInputFilter($inputFilter);
         			$form->setData($request->getPost());
         			if ($form->isValid()) {
         			    $this->numberRangeTable->deleteAll();
         			    $data = $form->getData();
         			    
         			    foreach ($data['chk_group'] as $chk)
         			    {
         			        $numberRange = new NumberRange();
         			        $numberRange->value = $chk;
         			        $this->numberRangeTable->saveNumberRange($numberRange);         			        
         			    }
          			    $this->flashMessenger()->addMessage('Диапазон допустимых внутренних номеров сохранен');                		 		    
         			    return $this->redirect()->toRoute('vpbxui/settings/numberallowed');
         			}
        }
        else {
            $numberRanges = $this->numberRangeTable->fetchAll();
            $chkgroup = array();
            
            foreach ($numberRanges as $numberRange)
            {
                $chkgroup[$numberRange->value] = $numberRange->value;
            }
            $form->setData(array('chk_group'=>$chkgroup));
        }
        
         
        return array(
            'form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages()            
        );
    }
}