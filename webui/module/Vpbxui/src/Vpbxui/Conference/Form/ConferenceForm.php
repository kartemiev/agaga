<?php
namespace Vpbxui\Conference\Form;

use Zend\Form\Form;
use Vpbxui\ConferenceFree\Model\ConferenceFreeTableInterface;
 class ConferenceForm extends Form
{
    protected $conferenceFreeTable;
    public function __construct(ConferenceFreeTableInterface $conferenceFreeTable)
    {
        parent::__construct('conference');
        $this->conferenceFreeTable = $conferenceFreeTable;
        
        $this->setAttribute('method', 'post');

        $this->setUseInputFilterDefaults(false);
        $this->setAttribute('autocomplete', 'off');
        
        $this->add(array(
             'name' => 'confnumber',
            'attributes' =>  array(
                'id' => 'confnumber',
                 'class'=> 'selectspecial'
            ),
            'options' => array(
                'label' => '',
                'label_attributes' => array(
                    'class'  => 'bold-label'
                ),
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'reserveduration',
            'attributes' =>  array(
                'id' => 'joinacl',
                'value'=>array('checked'=>'0'),
                'options' => array(
                         '1' => array(
                            'label' => 'на сутки',
                            'value' => '0',
                            'attributes' => array(
                                'data-item' => 'apple',
                             ),
                        ),
                        'week' => array(
                            'label' => 'на неделю',
                            'value' => '1',
                            'attributes' => array(
                                'data-item' => 'orange',
                            ),
                        ),
                         
                    )
                ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'joinacl',
             
            'attributes' =>  array(
                'value'=>array('checked'=>'ALL'),                
                'id' => 'joinacl',
                'options' => array(
                        'ALL' => 'телеконференция доступна всем',
                        'INTERNALONLY' => 'телеконференция доступна только абонентам НУЦ'
                    ),
            ),
            'options' => array(
                'label' => '',
            ),
        ));
        
        $this->add(array(
            'name' => 'pin',
            'attributes' => array(
                'id' =>'pin',
                'type'  => 'password',
                'placeholder'=> 'пин-код (опционально)'
              ),
            'options' => array(
                'label' => ''                 
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            ))
        );
         /*
        $captcha =  new \Zend\Captcha\Image;
        $captcha->setFont(dirname(__FILE__).'/../../../../../../public/otf/Moms_typewriter.ttf');
        $captcha->setImgDir(dirname(__FILE__).'/../../../../../../public/captcha');
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Введите число на картинке',
                'captcha' => $captcha,
            ),
        ));
        */
        $this->add(array(
            'name' => 'submit',
            'attributes' => array('type' => 'submit', 'value' => 'Go', 'class' => 'btn btn-primary'),
             'options'   => array('label' => ' ')
        ));
        
    }
}