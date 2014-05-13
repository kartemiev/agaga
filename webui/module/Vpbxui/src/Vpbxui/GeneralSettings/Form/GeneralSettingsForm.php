<?php
namespace Vpbxui\GeneralSettings\Form;

use Zend\Form\Form;
use Vpbxui\MediaRepos\Model\MediaReposTable;
use Zend\Db\Sql\Where;

class GeneralSettingsForm extends Form {

    protected $mediaReposTable; 
    public function __construct(MediaReposTable $mediaReposTable)
    {
        $this->mediaReposTable = $mediaReposTable;
     	parent::__construct('generalsettings');
    	$this->setAttribute('method', 'post');
     	 
    	$this->add(array(
    			'name' => 'id',
    			'attributes' => array(
    					'type'  => 'hidden',
    			),
    	));
     	
    	 
    	$this->add(array(
    	    'type' => 'Zend\Form\Element\Select',
    	    'name' => 'greeting',
    	    'attributes' =>  array(
    	        'id' => 'greeting',
    	        'class'=>'selectpicker show-tick',
    	        'options' => $this->getSelectOptions('GREETING'),    	         
    	        'data-live-search'=>'true'    	  
    	    ),
    	    'options' => array(
    	        'label' => 'приветствие в рабочее время',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
    	$this->add(array(
    	    'type' => 'Zend\Form\Element\Select',
    	    'name' => 'greetingofftime',
    	    'attributes' =>  array(
    	        'class'=>'selectpicker',    	         
    	        'id' => 'greetingofftime',
    	        'options' => $this->getSelectOptions('GREETING'),
    	        'data-live-search'=>'true'    	  
    	    ),
    	    'options' => array(
    	        'label' => 'приветствие во внерабочее время',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
    	$this->add(array(
    	    'type' => 'Zend\Form\Element\Select',
    	    'name' => 'mohtone',
    	    'attributes' =>  array(
    	        'id' => 'mohtone',
    	        'options' => $this->getSelectOptions('MISICONHOLD'),
    	        'class'=>'selectpicker',    	         
     	        'data-live-search'=>'true'    	  
    	    ),
    	    'options' => array(
    	        'label' => 'мелодия на удержание',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Radio',
    			'name' => 'mohinternal',
    			'options' => array(
    					'value_options' => array(
    							'active'=>'мелодия звонка для внутренних вызовов включена',
    							'disabled'=>'мелодия звонка для внутренних вызовов отключена',    	
    					),
    					 
    			)
    	));
    	
    	
    	$this->add(array(
    	    'type' => 'Zend\Form\Element\Select',
    	    'name' => 'ringingtone',
    	    'attributes' =>  array(
    	        'class'=>'selectpicker',
    	         'id' => 'ringingtone',
    	        'options' => $this->getSelectOptions('RINGBACKTONE'),    	         
    	        'data-live-search'=>'true'    	  
    	    ),
    	    'options' => array(
    	        'label' => 'мелодия звонка',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
    	$this->add(array(
    	    'name' => 'vmtimeout',
    	    'attributes' => array(
    	        'id' => 'vmtimeout',
    	        'type'  => 'text',
                 'class'=>"slider", 
    	        'data-slider-min'=>"0", 
    	        'data-slider-max'=>"30", 
    	        'data-slider-step'=>"1",
    	        'data-slider-orientation'=>"horizontal",
    	        'data-slider-selection'=>"before",
    	        'data-slider-handle'=>'triangle'
     	    ),
    	    'options' => array(
    	        'label' => 'преадресация на голосовую почту во внерабочее время,<br> через, сек',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
     	$this->add(array(
    			'name' => 'submit',
    			'attributes' => array(
    					'type'  => 'submit',
    					'value' => 'Сохранить',
    					'id' => 'submitbutton',
    			        'class'=>'btn btn-primary'
    			),
    	    'options' => array(
    	        'label' => '&nbsp',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ))
    	));
    	
    	
    }
    public function getSelectOptions($mediatype)
    {
        $filter = new Where();
        $filter->in('mediatype',array($mediatype,'ANYMEDIA'))
                ->AND
                ->equalTo('vpbxid', 1);
        $mediarepos = $this->mediaReposTable->fetchAll($filter);
        $options=array(NULL=>'');
        
         foreach ($mediarepos as $mediareposrec)
        {
            if (isset($mediareposrec->id)){
                $format = (''==$mediareposrec->custdesc)?'%s%s':'%s (%s)';                
                $label = sprintf($format, $mediareposrec->custdesc, $mediareposrec->custname); 
                 $span = (''==$mediareposrec->extension)?'': "<i class='icon-music'></i><span class='label label-success'>".$mediareposrec->extension."</span> ";
                $options[]  =   array(
                    'label' => $label,
                    'value' => $mediareposrec->id,
                
                    'attributes' => array(                        
                        'data-content' => $span.$label
                    ),
                );                
            }
            
        }
        
        return $options;
    }
    
}
