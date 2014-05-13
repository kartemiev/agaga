<?php
namespace Vpbxui\Extension\Form;

use Zend\Form\Form;
use Vpbxui\ExtensionGroup\Model\ExtensionGroupTable;
use Vpbxui\PickupGroup\Model\PickupGroupTable;
use Vpbxui\Extension\Model\ExtensionTable;
use Vpbxui\FreeExtension\Model\FreeExtensionTable;
use Vpbxui\CallDestination\Model\CallDestinationTable;
use Vpbxui\Route\Model\RouteTable;

class ExtensionForm extends Form {

    protected $extensionGroupTable;
    protected $pickupGroupTable;
    protected $freeExtensionTable;
    public  $callDestinationTable;
    protected $routeTable;    
    public function __construct($name = null, 
        ExtensionGroupTable $extensionGroupTable, 
        PickupGroupTable $pickupGroupTable,
        ExtensionTable $extensionTable,
        FreeExtensionTable $freeExtensionTable,
		CallDestinationTable $callDestinationTable,
    	RouteTable $routeTable    		
        )
    {
        $this->extensionGroupTable = $extensionGroupTable;
        $this->pickupGroupTable = $pickupGroupTable;
        $this->freeExtensionTable = $freeExtensionTable;
        $this->callDestinationTable = $callDestinationTable;
        $this->routeTable = $routeTable;
    	parent::__construct('extension');
    	$this->setAttribute('method', 'post');
    //	$this->setAttribute('class', 'form-horizontal');
    	 
    	$this->setAttribute('autocomplete', 'off');
    //	$this->setAttribute('class', 'form-horizontal');    	 
    	$this->setUseInputFilterDefaults(false);
    	$this->add(array(
    			'name' => 'id',
    			'attributes' => array(
    					'type'  => 'hidden',
    			),
    	));

    	
    	$freeExtensions = $this->freeExtensionTable->fetchAll();
    	$freeExts = array();
    	foreach ($freeExtensions as $extension)
    	{
    	    $freeExts[strval($extension->ext)]=strval($extension->ext);
    	}
     
    	$this->add(array(
    	    'name' => 'custname',
    	    'attributes' => array(
    	        'type'  => 'input-small',
    	        'title'=>'ФИО сотрудника для внутреннего учета',
    	       'placeholder'=>'ввод...'  
    	    ),
    	    'options' => array(
    	        'label' => 'имя сотрудника',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
    	
    	$this->add(array(
    	    'type' => 'Zend\Form\Element\Select',
    	    'name' => 'extension',
    	    'attributes' =>  array(
    	        'id' => 'extension',
      	        'options' => $freeExts,
    	        'title'=>'номер АТС в системе нумерации Национального Удостоверяющего Центра',
    	    ),
    	    'options' => array(
    	        'label' => 'внутренний номер',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
    	 
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Select',
    			'name' => 'number_status',
    			'attributes' =>  array(
    					'id' => 'number_status',
    					'options' =>
    					array(
    							'UNDEFINED'=>'',
    							'ACTIVE'=>'отсутствует',
    							'SUSPENDED'=>'временно заблокирован'
    					),
    			),
    			'options' => array(
    					'label' => 'блокировка',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    $this->add(array(
    			'name' => 'callerid',
    			'attributes' => array(
    					'type'  => 'text',
     			    'title'=> 'буквенный идентификатор абонента который будет отображаться при внутренних вызовах (как правило - написание фамилии и инициалы в латинской транслитерации)',    			    	
                    'placeholder' => 'ввод...'
    			),
    			'options' => array(
    					'label' => 'имя отобр.ТА (лат.)',
    			    'label_attributes' => array(
    			        'class'  => 'bold-label'
    			    ),
    			),
    	));
       
       $this->add(array(
           'name' => 'name',
           'attributes' => array(
               'id' =>'name',
               'type'  => 'text',
                'title'=>'идентификатор для регистрации абонентского SIP-устройства на станционном оборудовании (должен быть уникальным, может совпадать с внутренним номером)',                
                'class'=>'sipdetails'
           ),
           'options' => array(
               'label' => 'SIP ID',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
    
       
       $this->add(array(
           'name' => 'secret',           
           'attributes' => array(
               'id' =>'secret',                
               'type'  => 'password',
                'title'=>'пароль для регистрации абонентского устройства SIP-устройства на станционном оборудовании',
               'class'=>'sipdetails'        
           ),
           'options' => array(
               'label' => 'пароль',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
     
        
       
       $this->add(array(
           'name' => 'copypass',
           'attributes' => array(
               'type'  => 'button',
               'id' => 'copypass',
               'value' => 'скопировать',
               'class'  => 'btnaslink',
           ),
           'options' => array(
               'label_attributes' => array(
                   'class'  => 'btnaslink'
               ),
           ),
            
            
       ));
       $this->add(array(
           'name' => 'clearpass',
           'attributes' => array(
               'type'  => 'button',
               'id' => 'clearpass',
               'value' => 'очистить',
               'class'  => 'btnaslink',
           ),
           'options' => array(
               'label_attributes' => array(
                   'class'  => 'btnaslink'
               ),
           ),
       
       
       ));
       
       $this->add(array(
           'name' => 'generatepass',
           'attributes' => array(
               'type'  => 'button',
               'id' => 'generatepass',
               'value' => 'сгенерировать',
               'class'  => 'btnaslink',
           ),
           'options' => array(
               'label_attributes' => array(
                   'class'  => 'btnaslink'
               ),
           ),
            
            
       ));
       
       $this->add(array(
           'name' => 'showpass',
           'attributes' => array(
               'type'  => 'button',
               'id' => 'showpass',
               'value' => 'показать',
               'class'  => 'btnaslink',
           ),
           'options' => array(
               'label_attributes' => array(
                   'class'  => 'btnaslink'
               ),
           ),
            
            
       ));
       
       $this->add(array(
           'name' => 'email',
           'attributes' => array(
               'type'  => 'email',
               'title'=> 'e-mail для приема факсов на e-mail и сообщений голосовой почты',
           ),
           'options' => array(
               'label' => 'адрес электронной почты',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       
       $this->add(array(
           'name' => 'permit',
           'attributes' => array(
               'type'  => 'text',
               'title'=> 'маска разрешенных IP',
           ),
           'options' => array(
               'label' => 'IP разр.',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $this->add(array(
           'name' => 'deny',
           'attributes' => array(
               'type'  => 'text',
               'title'=> 'маска запрещенных IP',
           ),
           'options' => array(
               'label' => 'IP запр.',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'extensiontype',
           'attributes' =>  array(
               'id' => 'extensiontype',
           	'class'=> 'subfieldsetshuffle-control',           		 
               'title'=>'тип абонента - является ли оператором колл-центра. Внимание! - после создания абонента изменение этого поля будет запрещено для правильного учета статистики.',
               'options' => array(
                   'regular' => 'обычный',
                   'operator' => 'оператор',
                   'fax' => 'факс'
               ),
           ),
           'options' => array(
               'label' => 'тип номера',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $routeFormOptions = $this->getRouteFormOptions();
        
       $routeref = $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'routeref',
       		'attributes' =>  array(
       				'id' => 'routeref',
       				'options' => $routeFormOptions,
       				'title'=> 'маршрут',
       		),
       		'options' => array(
       				'label' => 'маршрут',
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));
        
       
       $extensionGroupFormOptions = $this->getExtensionGroupFormOptions();
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'extensiongroup',
           'attributes' =>  array(
               'id' => 'extensiongroup',
               'options' => $extensionGroupFormOptions,
               'title'=> 'принадлежность абонента к группе',                
           ),
           'options' => array(
               'label' => 'группа',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       
       
       
       $pickupGroupFormOptions = $this->getPickupGroupFormOptions();
       
        
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'namedpickupgroup',
           'attributes' =>  array(
               'id' => 'namedpickupgroup',
                'options' => $pickupGroupFormOptions,
               'title'=> 'группа перехвата вызовов вызовы из которой абонент может перехватывать',
               
           ),
           'options' => array(
               'label' => 'группа перехвата (перехват)',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
        
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'namedcallgroup',
           'attributes' =>  array(
               'id' => 'namedcallgroup',
                'options' => $pickupGroupFormOptions,
               'title'=> 'группа перехвата вызовов в которую помещаются вызовы на абонентское устройство данного абонента',                
           ),
           'options' => array(
               'label' => 'группа вызовов (перехват)',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));

       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'extensionrecord',
       		'attributes' =>  array(
       				'id' => 'extensionrecord',
       				'title'=> 'запись переговоров',
       				'options' => array(
               	   'undefined' => '',
                   'active' => 'включена',
                   'disabled' => 'выключена',
               ),
       		),
       		'options' => array(
       				'label' => 'запись переговоров',
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));
        
     
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'outgoingcallspermission',
           'attributes' =>  array(
               'id' => 'outgoingcallspermission',
                'title'=> 'настройка привилегии совершения исходящих вызовов на номера телефонной сети общего пользования',                
               'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешены',
                   'barred' => 'запрещены',
               ),
           ),
           'options' => array(
               'label' => 'исходящие вызовы',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'transfer',
           'attributes' =>  array(
               'id' => 'transfer',
               'title'=> 'настройка привилегии перевода вызовов',                
                'options' => array(
                   'undefined' => '',
                   'allowed' => 'разрешен',
                   'forbidden' => 'запрещен',
               ),
           ),
           'options' => array(
               'label' => 'услуга слепого и стандартного перевода вызова',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'hold',
           'attributes' =>  array(
               'title'=> 'настройка привилегии услуги удержания вызовов',                
               'id' => 'hold',
                'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешено',
                   'forbidden' => 'запрещено',
               ),
           ),
           'options' => array(
               'label' => 'услуга удержания вызова',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
        
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'statuschange',
           'attributes' =>  array(
               'title'=> 'настройка привилегии изменения статуса оператора колл-центра',                
               'id' => 'statuschange',
               'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешено',
                   'forbidden' => 'запрещено',
               ),
           ),
           'options' => array(
               'label' => 'изменение статуса оператора колл-центра',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'incoming',
           'attributes' =>  array(
               'id' => 'incoming',
               'title'=> 'настройка привилегии приема входящих звонков (как с городских так и с внутренних - общая настройка)',                
                'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешен',
                   'forbidden' => 'запрещен',
               ),
           ),
           'options' => array(
               'label' => 'прием входящих вызовов',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));


       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'busylevel',
       		'attributes' =>  array(
       				'id' => 'busylevel',
       				'title'=> 'количество вх.линий',
       				'options' => array(
       						'1' => '1',
       						'2' => '2',
       						'3' => '3',
       						'4' => '4',
       						'5' => '5',
       						'6' => '6',
       						'7' => '7',
       						'8' => '8',
       						'9' => '9',
       						'10' => '10',
       						'11' => '11',
       						'12' => '12',
       						'13' => '13',
       						'14' => '14',
       						'15' => '15'       						 
        				),
       		),
       		'options' => array(
       				'label' => 'количество вх.линий',
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));        

        
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'memberofcallcentreque',
           'attributes' =>  array(
               'title'=> 'только для операторов колл-центра: учавствует ли в приеме входящих вызовов в колл-центр',                
               'id' => 'memberofcallcentreque',
           		'class'=> 'subfieldsetshuffle-data',
           		'data-value'=> 'operator',           		 
               'options' => array(
                   'undefined' => '',
                   'true' => 'да',
                   'false' => 'нет',
               ),
           ),
           'options' => array(
               'label' => 'является участником очереди колл-центра на прием звонков',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
        
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'forwarding',
           'attributes' =>  array(
                'title'=> 'настройка привелегии услуги установки переадресации вызовов',                
               'id' => 'forwarding',
               'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешена',
                   'forbidden' => 'запрещена',
               ),
           ),
           'options' => array(
               'label' => 'установка/снятие переадресации вызова',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));  

       
       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'diversion_unconditional_status',
       		'attributes' =>  array(
       				'id' => 'diversion_unconditional_status',
       				'options' => array('UNDEFINED'=>'', 'ACTIVATED'=>'активна', 'DEACTIVATED'=>'неактивна'),
       		),
       		'options' => array(
       				'label' => 'безусловная',
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));


       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'diversion_unconditional_landingtype',
       		'attributes' =>  array(
       				'id' => 'diversion_unconditional_landingtype',
       				'class'=> 'subfieldsetshuffle-control',       				 
        				'options' => array('NUMBER'=>'номер', 'VOICEMAIL'=>'голосовая почта', 'FAX'=>'факс'),
       		),
       		'options' => array(
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));
       
               
       $this->add(array(
       		'name' => 'diversion_unconditional_number',
       		'attributes' => array(
       				'type'  => 'text',
       				'class'=> 'subfieldsetshuffle-data',
       				'data-value'=> 'NUMBER',
       				//'placeholder'=> 'номер...',
       		),
       ));
        
       
       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'diversion_unavail_status',
       		'attributes' =>  array(
       				'id' => 'diversion_unavail_status',
       				'options' => array('UNDEFINED'=>'', 'ACTIVATED'=>'активна', 'DEACTIVATED'=>'неактивна'),
       		),
       		'options' => array(
       				'label' => 'отключен',
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));

       

       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'diversion_unavail_landingtype',
       		'attributes' =>  array(
       				'id' => 'diversion_unavail_landingtype',
       				'class'=> 'subfieldsetshuffle-control',       				 
       				'options' => array('NUMBER'=>'номер', 'VOICEMAIL'=>'голосовая почта', 'FAX'=>'факс'),
       		),
       		'options' => array(
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));
        
       
       $this->add(array(
       		'name' => 'diversion_unavail_number',
       		'attributes' => array(
       				'type'  => 'text',
       				'class'=> 'subfieldsetshuffle-data',
       				'data-value'=> 'NUMBER',
       		//		'placeholder'=> 'номер...',
       		),
       ));
        
       
       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'diversion_busy_status',
       		'attributes' =>  array(
       				'id' => 'diversion_busy_status',
       				'options' => array('UNDEFINED'=>'', 'ACTIVATED'=>'активна', 'DEACTIVATED'=>'неактивна'),
       		),
       		'options' => array(
       				'label' => 'занято',
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));
       

       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'diversion_busy_landingtype',       		
       		'attributes' =>  array(
       				'id' => 'diversion_busy_landingtype',
       				'class'=> 'subfieldsetshuffle-control',       				 
       				'options' => array('NUMBER'=>'номер', 'VOICEMAIL'=>'голосовая почта', 'FAX'=>'факс'),
       		),
       		'options' => array(
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));
       
       $this->add(array(
       		'name' => 'diversion_busy_number',
       		'attributes' => array(
       				'type'  => 'text',
       				'class'=> 'subfieldsetshuffle-data',
       				'data-value'=> 'NUMBER',
       			//	'placeholder'=> 'номер...',
       		),
       ));
       
       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'diversion_noanswer_status',
       		'attributes' =>  array(
       				'id' => 'diversion_noanswer_status',
        				'options' => array('UNDEFINED'=>'', 'ACTIVATED'=>'активна', 'DEACTIVATED'=>'неактивна'),
       		),
       		'options' => array(
       				'label' => 'неответ',
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));
       
       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'diversion_noanswer_landingtype',
       		'attributes' =>  array(
       				'id' => 'diversion_noanswer_landingtype',
       				'class'=> 'subfieldsetshuffle-control',       				 
       				'options' => array('NUMBER'=>'номер', 'VOICEMAIL'=>'голосовая почта', 'FAX'=>'факс'),
       		),
       		'options' => array(
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));
       
       $this->add(array(
       		'name' => 'diversion_noanswer_number',
       		'attributes' => array(
       				'type'  => 'text',
       				'class'=> 'subfieldsetshuffle-data',       				 
       				//'placeholder'=> 'номер...',
       				'data-value'=> 'NUMBER',       				 
       		),
       ));
       
       $this->add(array(
       		'name' => 'diversion_noanswer_duration',
       		'attributes' => array(
       				'type'  => 'text',
       				'class'=>"slider",
       				'data-slider-min'=>"0",
       				'data-slider-max'=>"60",
       				'data-slider-step'=>"1",
       				'data-slider-orientation'=>"horizontal",
       				'data-slider-selection'=>"before",
       				'data-slider-handle'=>'triangle'
       		),
       		 
       ));
        
       
       
       $this->add(array(
           'name' => 'custdesc',
           'attributes' => array(
                'title'=> 'комментарий для внутреннего пользования',                
               'type'  => 'input-small',
               'placeholder' => 'ввод...'        
           ),
           'options' => array(
               'label' => 'комментарий',               
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       $actions = new \Zend\Form\Fieldset('actions');
       /* 
    	$actions->add(array(
    			'name' => 'submit',
    			'attributes' => array(
    					'type'  => 'submit',
    					'value' => 'Go',
    					'id' => 'submitbutton',
    			),
    	));
    	*/
       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'callsequence',
       		'attributes' =>  array(
       				'id' => 'callsequence',
       				'class'=> 'subfieldsetshuffle-control',       				 
        			'options' => array(
       						'SEQUENTIAL' => 'последовательно',
       						'SIMULRING' => 'одновременно',
       				),
       		),
       		'options' => array(
       				'label'=> 'стратегия вызова',
       				'label_attributes' => array(
       						'class'  => 'bold-label'
       				),
       		),
       ));
       $numbers = $this->add(array(
       		'type' => 'Zend\Form\Element\Collection',
       		'name' => 'numbers',
       		'options' => array(
       		//		'label' => 'Выберите номера на которые будут направлены вызовы',
       				'count' => 0,
       				'should_create_template' => true,
       				'template_placeholder' => 'numbers', 
       				'allow_add' => true,
       				'target_element' => array(
       						'type' => 'Vpbxui\Extension\Form\CallGroupFieldset'
       				),
        		)
       ));
                     
       $actions->add(array(
           'name' => 'submit',
           'attributes' => array('type' => 'submit', 'value' => 'Go', 'class' => 'btn btn-primary'),
           'attributes' => array('type' => 'submit', 'value' => 'Go', 'class' => 'primaryAction'),
           'options'   => array('label' => 'Submit')
       ));
    	$this->add($actions);
    	 
    	 
    }
    protected function getExtensionGroupFormOptions()
    {
        $extensionGroupTable = $this->extensionGroupTable;
        $extensionGroups = $extensionGroupTable->fetchAll();
        $extensionGroupOptions = array(0 => '');
        foreach ($extensionGroups as $extensionGroup)
        {
            $extensionGroupOptions[$extensionGroup->id] = $extensionGroup->name;
        }
        return $extensionGroupOptions;
    }
    protected function getPickupGroupFormOptions()
    {
        $pickupGroupTable = $this->pickupGroupTable;
        $pickupGroups = $pickupGroupTable->fetchAll();
        $pickupGroupOptions = array(0 => '');
        foreach ($pickupGroups as $pickupGroup)
        {
            $pickupGroupOptions[$pickupGroup->name] = $pickupGroup->custname;
        }
        return $pickupGroupOptions;
    }    
    
     protected function getRouteFormOptions()
    {
    	$routeTable = $this->routeTable;
    	$routes = $routeTable->fetchAll();
    	$routeOptions = array(NULL => '');
    	foreach ($routes as $route)
    	{
    		$routeOptions[$route->id] = $route->custname;
    	}
    	return $routeOptions;
    }
 }
