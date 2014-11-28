<?php
//return array();
 
return array(
    'navigation' => array(
        'default'=>array(
           
            'conference'=>array(
                'label' => 'телеконференция',
                'title'=>'создание комнат телеконференций',
                'route' => 'createconference',
                'privilege' => 'index',
                'resource'   => 'mvc:conferencecreate.vpbxui', // resource
                'controller' => 'Vpbxui\Controller\ConferenceBooking',
             ),
           
            'login'=> array(
            		'label'=>'вход',
                'title'=>'вход в защищенную область',
                
            		'route'=>'zfcuser/login',
            		'module'     => 'vpbxui',
            		'controller' => 'zfcuser',
            		'action'     => 'login',
                    'resource'   => 'mvc:login.vpbxui', // resource
            		'visible'    => true, // not visible                        
            ),

        		 
             
         'internal' => array(
             'id'=>'internal',
        'label'=>'абоненты',
         'title'=>'просмотр списка абонентов',              
         'route'=>'vpbxui/internal',   
         'module'     => 'vpbxui',
         'resource'   => 'mvc:internalnumber.vpbxui', // resource
         'privilege' => 'list',              
         'controller' => 'Vpbxui\Controller\Internal',
         'action' => 'index',
             'params'=>array(),              
        'visible'    => true, // not visible
             'pages' => array( 
             array(
             'id'=>'internal',
             'label'=>'обзор',
             'title'=>'просмотр списка абонентов',
             'route'=>'vpbxui/internal',
             'module'     => 'vpbxui',
             'resource'   => 'mvc:internalnumber.vpbxui', // resource
             'privilege' => 'list',
             'controller' => 'Vpbxui\Controller\Internal',
             'action' => 'index',
                  ),  
                 array(
                 		'label' => 'добавить',
                 	    'title'=>'добавление абонента',
                 		'route'=>'vpbxui/internal',
                 		'module'     => 'vpbxui',
                 		'controller' => 'Vpbxui\Controller\Internal',
                 		'action'     => 'add',
                        'resource'   => 'mvc:internalnumber.vpbxui', // resource
                 		'privilege' => 'add',
                 		'order' => 10000,                 		 
                 		'visible'    => true, // not visible
                   		                 ),
                  
                                  ),
        ),
        
        'monitoring'=>array(
            'label' => 'мониторинг',
            'title'=> 'мониторинг номерной емкости',            
            'route' => 'vpbxui/callcentre/monitoring',
            'module' => 'vpbxui',
            'controller'=>'Vpbxui\Controller\Monitoring',
            'action'     => 'index',
            'resource'   => 'mvc:callcentremonitoring.vpbxui', // resource
            'privilege' => 'list',
            'pages'=>
            array(array(
                'label' => 'мониторинг транков и номеров',
                'title'=> 'отслеживание регистраций SIP устройств, транков и прохождения вызовов в режиме online',
                'route' => 'vpbxui/callcentre/monitoring',
                'module' => 'vpbxui',
                'controller'=>'Vpbxui\Controller\Monitoring',
                'action'     => 'index',
                'resource'   => 'mvc:callcentremonitoring.vpbxui', // resource
                'privilege' => 'list',            
            ),
                array('label' => 'перезагрузка АТС',
                'title'=>'сброс и перезагрузка программной АТС',                
                    'route' => 'vpbxui/callcentre/monitoring',
                    'module' => 'vpbxui',
                    'controller'=>'Vpbxui\Controller\Monitoring',
                    'action'     => 'restart',
                    'resource'   => 'mvc:asterreboot.vpbxui', // resource
                    'privilege' => 'restart',
                    'visible'=>true,
            )            
            )
        ),
         
        
        'stats' => array(
            'label' => 'статистика',
            'title'=>'статистика по колл-центру',            
            'route' => 'vpbxui/callcentre/stats',
            'module' => 'vpbxui',
            'controller' => 'Vpbxui\Controller\CallCentreStats',
            'action' => 'index',
             'resource'   => 'mvc:callcentrestats.vpbxui', // resource
            'privilege' => 'list',
        
            'pages' => array(
                'callcentre' => array(
                'label' => 'колл-центр',
                'title'=>'статистика по колл-центру',
                'route' => 'vpbxui/callcentre/stats',
                'module' => 'vpbxui',
                'controller' => 'Vpbxui\Controller\CallCentreStats',
                'action' => 'index',
                'resource'   => 'mvc:callcentrestats.vpbxui', // resource
                'privilege' => 'list',
                ),
                'operators'=>array(
                    'label' => 'операторы',
                    'title'=>'статистика в разрезе операторов колл-центра',                    
                    'route' => 'vpbxui/callcentre/stats/operators',
                    'module' => 'vpbxui',
                    'controller' =>'Vpbxui\Controller\CallCentreStatsOperators',
                    'action'     => 'index',
                    'resource'   => 'mvc:callcentrestatsoperators.vpbxui', // resource
                    'privilege' => 'index',
                    'visible'=> true,
                    'pages' =>  array(                         
                    ),        
                ),     
                'calls'=>array(
                    'label' => 'пропущенные',
                    'title'=>"детализированный\nпросмотр вызовов\nпропущенных\nоператорами колл-центра",
                    'route' => 'vpbxui/callcentre/stats/operators/missed',
                    'module' => 'vpbxui',
                    'controller' =>'Vpbxui\Controller\CdrMissedCallsCallCentre',
                    'action'     => 'index',
                    'resource'   => 'mvc:callcentrestatsoperators.vpbxui', // resource
                    'privilege' => 'index',
                    'visible'=> true,
                    'pages' =>  array(
                    ),
                ),
            ),
             
        ),
         
         'cdr' => array(
        		'label'=>'детализация',
        		'title'=>'просмотр записей об обработанных станцией вызовах',        		
        		'route'=>'vpbxui/cdr',
                		'module'     => 'vpbxui',
                 		'controller' => 'Vpbxui\Controller\Cdr',
                 		'action'     => 'index',
                 		'privilege' => 'list',                 		 
                 		'resource'   => 'mvc:cdr.vpbxui', // resource                 		          
            'pages' => array(
                 array(
                 		'label' => 'все',
                 		'route'=>'vpbxui/cdr',
                 		'module'     => 'vpbxui',
                 		'controller' => 'Vpbxui\Controller\Cdr',
                 		'action'     => 'index',
                                'resource'   => 'mvc:cdr.vpbxui', // resource                 		          
                 		'privilege' => 'list',                 		 
                 		'visible'    => true, // not visible
                  ),
                  array(
                  		'label' => 'поиск',
                  		'route'=>'vpbxui/cdr',
                  		'module'     => 'vpbxui',
                  		'controller' => 'Vpbxui\Controller\Cdr',
                  		'action'     => 'find',
                  		'resource'   => 'mvc:cdrfind.vpbxui', // resource
                  		'privilege' => 'find',
                  		'visible'    => false, // not visible
                  ),
                array(
                      'label' => 'последний час',
                      'route'=>'vpbxui/cdr',
                      'module'     => 'vpbxui',
                      'controller' => 'Vpbxui\Controller\Cdr',
                      'action'     => 'index',
                      'resource'   => 'mvc:cdr.vpbxui', // resource
                      'privilege' => 'list',                  
                      'visible'    => true, // not visible
                      'query'=>array('scope'=>'thishour')                      
                  ),
                  
                  array(
                      'label' => 'сегодня',
                      'route'=>'vpbxui/cdr',
                      'module'     => 'vpbxui',
                      'controller' => 'Vpbxui\Controller\Cdr',
                      'action'     => 'index',
                      'resource'   => 'mvc:cdr.vpbxui', // resource
                      'privilege' => 'list',                  
                      'visible'    => true, // not visible
                      'query'=>array('scope'=>'today')                      
                                        ),
                  array(
                      'label' => '24 часа',
                      'route'=>'vpbxui/cdr',
                      'module'     => 'vpbxui',
                      'controller' => 'Vpbxui\Controller\Cdr',
                      'action'     => 'index',
                      'resource'   => 'mvc:cdr.vpbxui', // resource
                      'privilege' => 'list',
                  
                      'visible'    => true, // not visible
                      'query'=>array('scope'=>'24hours')                      
                                        ),
                  array(
                      'label' => 'месяц',
                      'route'=>'vpbxui/cdr',
                      'module'     => 'vpbxui',
                      'controller' => 'Vpbxui\Controller\Cdr',
                      'action'     => 'index',
                      'resource'   => 'mvc:cdr.vpbxui', // resource
                      'privilege' => 'list',
                  
                      'visible'    => true, // not visible
                      'query'=>array('scope'=>'thismonth')                      
                                            
                  ),
                  
                  array(
                      'label' => '30 дней',
                      'route'=>'vpbxui/cdr',
                      'module'     => 'vpbxui',
                      'controller' => 'Vpbxui\Controller\Cdr',
                      'action'     => 'index',
                      'resource'   => 'mvc:cdr.vpbxui', // resource
                      'privilege' => 'list',
                  
                      'visible'    => true, // not visible
                      'query'=>array('scope'=>'past30days')
                  
                  ),
                                                    
                
                ),
            
        ),
        		
        	 
        
        'settings' => array(
            'label' => 'настройки',
            'title'=>'настройки программной АТС',            
            'module' => 'vpbxui',            
            'route' => 'vpbxui/settings',
            'privilege' => 'list',
            'controller' => 'Vpbxui\Controller\Settings',
            'action' => 'index',
            'resource'   => 'mvc:settings.vpbxui', // resource
            'pages'=>
            array(
              
                    array(
                        'label' => 'группы абонентов',
                        'title'=>'Просмотр списка групп абонентов',                        
                        'route' => 'vpbxui/settings/groups/internal',
                        'privilege' => 'internal',
                        'module' => 'vpbxui',
                        'controller'=>'Vpbxui\Controller\ExtensionGroup',
                        'action' => 'index',
                        'resource'   => 'mvc:settingsgroups.vpbxui', // resource
                        'pages' =>  array(
                            array(
                            'label' => 'добавить',
                            'title'=>'добавить новую группу абонентов',                            
                            'route' => 'vpbxui/settings/groups/internal',
                            'privilege' => 'internal',
                            'module' => 'vpbxui',
                            'controller' => 'Vpbxui\Controller\ExtensionGroup',
                            'action' => 'add',
                 		'order' => 10000,                 		 

                            'resource' => 'mvc:settingsgroups.vpbxui', // resource
                            ),
                        )
                    ),
                    array(
                        'label' => 'группы перехвата',
                        'title'=>'просмотр списка групп перехвата вызова',                        
                        'route' => 'vpbxui/settings/groups/pickup',
                        'privilege' => 'pickup',
                        'controller'=>'Vpbxui\Controller\PickupGroup',
                        'action' => 'index',                                                
                        'resource'   => 'mvc:settingsgroups.vpbxui', // resource
                        'pages' => array(
                            array(
                            'label' => 'добавить',
                            'title'=>'добавить новую группу перехвата вызовов',                            
                            'route'=>'vpbxui/settings/groups/pickup',
                            'module'     => 'vpbxui',
                            'controller' => 'Vpbxui\Controller\PickupGroup',
                            'action'     => 'add',
                            'resource'   => 'mvc:settingsgroups.vpbxui', // resource
                            'privilege' => 'pickup',
                            'visible'    => true, // not visible
                            'pages'=>array(),
                        ),
                        ),
                                                         
                ),
                array(
                    'label' => 'профили абонентов',
                    'title'=>'просмотр списка профилей абонентов',                    
                    'route' => 'vpbxui/settings/profile/internal',
                    'privilege' => 'list',
                    'controller'=>'Vpbxui\Controller\InternalProfile',
                    'action' => 'index',
                    'resource'   => 'mvc:settingsinternalprofile.vpbxui', // resource
                    'pages' => array(
                        array(
                            'label' => 'добавить',
                            'title'=>'добавить новый профиль абонента',                            
                            'route'=>'vpbxui/settings/profile/internal',
                            'module'     => 'vpbxui',
                            'controller' => 'Vpbxui\Controller\InternalProfile',
                            'action'     => 'add',
                            'resource'   => 'mvc:settingsinternalprofile.vpbxui', // resource
                            'privilege' => 'add',
                            'visible'    => true, // not visible
                            'pages'=>array(),
                        ),
                    ),
                ),
                array(
                    'label' => 'профили групп абонентов',
                    'title'=>'просмотр списка профилей групп абонентов',                    
                    'route' => 'vpbxui/settings/profile/group',
                    'privilege' => 'list',
                    'controller'=>'Vpbxui\Controller\InternalGroupProfile',
                    'action' => 'index',
                    'resource'   => 'mvc:settingsinternalgroupsprofile.vpbxui', // resource
                    'pages' => array(
                        array(
                            'label' => 'добавить',
                            'title'=>'добавить новый профиль групп абонентов',                            
                            'route'=>'vpbxui/settings/profile/group',
                            'module'     => 'vpbxui',
                            'controller' => 'Vpbxui\Controller\InternalGroupProfile',
                            'action'     => 'add',
                            'resource'   => 'mvc:settingsinternalgroupsprofile.vpbxui', // resource
                            'privilege' => 'add',
                            'visible'    => true, // not visible
                            'pages'=>array(),
                            'params'=>array()                            
                        ),
                    ),
                ),
                
                array(
                		'label' => 'авторизационные коды',
                		'title'=>'просмотр авторизационных кодов',
                		'route' => 'vpbxui/settings/authcode',
                		'privilege' => 'list',
                		'controller'=>'Vpbxui\Controller\AuthCode',
                		'action' => 'index',
                		'resource'   => 'mvc:settingsauthcode.vpbxui', // resource
                		'pages' => array(
                				array(
                						'label' => 'добавить',
                						'title'=>'добавить новый авторизационный код',
                						'route' => 'vpbxui/settings/authcode',                						
                						'module'     => 'vpbxui',
                						'controller' => 'Vpbxui\Controller\AuthCode',
                						'action'     => 'add',
                						'resource'   => 'mvc:settingsauthcode.vpbxui', // resource
                						'privilege' => 'add',
                						'visible'    => true, // not visible
                						'pages'=>array(),
                						'params'=>array()
                				),
                		),
                ),
                
                
                array(
                		'label' => 'по умолчанию',
                		'title'=>'настройки для действующие по умолчанию для абонентов',
                		'route' => 'vpbxui/settings/extensiondefaults',
                		'privilege' => 'edit',
                		'controller'=>'Vpbxui\Controller\ExtensionDefaults',
                		'action' => 'edit',
                		'resource'   => 'mvc:settingsextensiondefaults.vpbxui', // resource
                		'pages' => array(
                		array(
                				'label' => 'редактирование',
                				'title'=>'редактирование',
                				'route' => 'vpbxui/settings/extensiondefaults',
                				'module'     => 'vpbxui',
                				'controller' => 'Vpbxui\Controller\ExtensionDefaults',
                				'action'     => 'edit',
                				'resource'   => 'mvc:settingsextensiondefaults.vpbxui', // resource
                				'privilege' => 'edit',
                				'visible'    => true, // not visible
                				'pages'=>array(),
                				'params'=>array()
                		),
                		),
                ),
                array(
                		'label' => 'алиасы Skype',
                		'title'=>'просмотр списка алиасов Skype',
                		'route' => 'vpbxui/settings/skypealias',
                		'privilege' => 'list',
                		'controller'=>'Vpbxui\Controller\SkypeAlias',
                		'action' => 'index',
                		'resource'   => 'mvc:settingsskypealias.vpbxui', // resource
                		'pages' => array(
                				array(
                						'label' => 'добавить',
                						'title'=>'добавить новый алиас Skype',
                						'route' => 'vpbxui/settings/skypealias',
                						'module'     => 'vpbxui',
                						'controller' => 'Vpbxui\Controller\SkypeAlias',                						
                						'action'     => 'add',
                						'resource'   => 'mvc:settingsskypealias.vpbxui', // resource                						
                 						'privilege' => 'add',
                						'visible'    => true, // not visible
                						'pages'=>array(),
                						'params'=>array()
                				),
                		),
                ),        

                array(
                		'label' => 'транки',
                		'title'=>'просмотр транков',
                		'route' => 'vpbxui/settings/trunk',
                		'privilege' => 'list',
                		'controller'=>'Vpbxui\Controller\Trunk',
                		'action' => 'index',
                		'resource'   => 'mvc:settingstrunks.vpbxui', // resource
                		'pages' => array(
                				array(
                						'label' => 'добавить',
                						'title'=>'добавить новый транк',
                						'route'=>'vpbxui/settings/trunk',
                						'module'     => 'vpbxui',
                						'controller' => 'Vpbxui\Controller\Trunk',
                						'action'     => 'add',
                						'resource'   => 'mvc:settingstrunks.vpbxui', // resource
                						'privilege' => 'add',
                						'visible'    => true, // not visible
                						'pages'=>array(),
                				),
                		),
                ),
                
                array(
                		'label' => 'контекст',
                		'title'=>'контекст',
                		'route' => 'vpbxui/settings/context',
                		'privilege' => 'list',
                		'controller'=>'Vpbxui\Controller\Context',
                		'action' => 'index',
                		'resource'   => 'mvc:settingscontext.vpbxui', // resource
                		'pages' => array(
                				array(
                						'label' => 'добавить',
                						'title'=>'добавить контекст',
                						'route'=>'vpbxui/settings/context',
                						'module'     => 'vpbxui',
                						'controller' => 'Vpbxui\Controller\Context',
                						'action'     => 'add',
                						'resource'   => 'mvc:settingscontext.vpbxui', // resource
                						'privilege' => 'add',
                						'visible'    => true, // not visible
                						'pages'=>array(),
                				),
                		),
                ),
                
                array(
                		'label' => 'IVR',
                		'title'=>'просмотр IVR',
                		'route' => 'vpbxui/settings/ivr',
                		'privilege' => 'list',
                		'controller'=>'Vpbxui\Controller\Ivr',
                		'action' => 'index',
                		'resource'   => 'mvc:settingsivr.vpbxui', // resource
                	/*	'pages' => array(
                				array(
                						'label' => 'добавить',
                						'title'=>'добавить новый IVR',
                						'route'=>'vpbxui/settings/ivr',
                						'module'     => 'vpbxui',
                						'controller' => 'Vpbxui\Controller\Ivr',
                						'action'     => 'add',
                						'resource'   => 'mvc:settingsivr.vpbxui', // resource
                						'privilege' => 'add',
                						'visible'    => true, // not visible
                						'pages'=>array(),
                				),
                		),*/
                ),
                array(
                		'label' => 'маршруты',
                		'title'=>'просмотр IVR',
                		'route' => 'vpbxui/settings/route',
                		'privilege' => 'list',
                		'controller'=>'Vpbxui\Controller\Route',
                		'action' => 'index',
                		'resource'   => 'mvc:settingsroute.vpbxui',
                		'pages' => array(
                				array(
                						'label' => 'добавить',
                						'title'=>'добавить новый маршрут',
                						'route'=>'vpbxui/settings/route',
                						'module'     => 'vpbxui',
                						'controller' => 'Vpbxui\Controller\Route',
                						'action'     => 'add',
                						'resource'   => 'mvc:settingsroute.vpbxui',
                						'privilege' => 'add',
                						'visible'    => true,
                						'pages'=>array(),
                				),
                		),
                ),
                array(
                		'label' => 'фильтры номеров',
                		'title'=>'просмотр фильтров номеров',
                		'route' => 'vpbxui/settings/filter',
                		'privilege' => 'list',
                		'controller'=>'Vpbxui\Controller\NumberMatch',
                		'action' => 'index',
                		'resource'   => 'mvc:settingsfilter.vpbxui',
                		'pages' => array(
                				array(
                						'label' => 'добавить',
                						'title'=>'добавить новый фильтр номера',
                						'route'=>'vpbxui/settings/filter',
                						'module'     => 'vpbxui',
                						'controller' => 'Vpbxui\Controller\NumberMatch',
                						'action'     => 'add',
                						'resource'   => 'mvc:settingsfilter.vpbxui',
                						'privilege' => 'add',
                						'visible'    => true,
                						'pages'=>array(),
                				),
                		),
                ),
                array(
                		'label' => 'отправители факсов',
                		'title'=>'отправители факсов',
                		'route' => 'vpbxui/settings/faxuser',
                		'privilege' => 'list',
                		'controller'=>'Vpbxui\Controller\FaxUser',
                		'action' => 'index',
                		'resource'   => 'mvc:settingsfaxuser.vpbxui',
                		'pages' => array(
                				array(
                						'label' => 'добавить',
                						'title'=>'добавить нового отправителя факсов',
                						'route'=>'vpbxui/settings/faxuser',
                						'module'     => 'vpbxui',
                						'controller' => 'Vpbxui\Controller\FaxUser',
                						'action'     => 'add',
                						'resource'   => 'mvc:settingsfaxuser.vpbxui',
                						'privilege' => 'add',
                						'visible'    => true,
                						'pages'=>array(),
                				),
                		),
                ),
                array(
                    'label' => 'праздничные дни',
                    'title'=>'настройка выходных и праздничных дней, а также замены рабочих дней для приема вызовов колл-центром',
                    'route' => 'vpbxui/settings/offdays',
                    'privilege' => 'list',
                    'controller'=>'Vpbxui\Controller\Offday',
                    'action' => 'index',
                    'resource'   => 'mvc:settingsoffdays.vpbxui', // resource
                    'pages' => array(
                        array(
                            'label' => 'добавить',
                            'title'=>'добавить новый выходной день/замену',
                            'route'=>'vpbxui/settings/offdays',
                            'module'     => 'vpbxui',
                            'controller' => 'Vpbxui\Controller\Offday',
                            'action'     => 'add',
                            'resource'   => 'mvc:settingsoffdays.vpbxui', // resource
                            'privilege' => 'add',
                            'visible'    => true, // not visible
                            'pages'=>array(
                        
                        ),                        
                        ),
                        
                        array(
                            'label' => 'импорт CSV',
                            'title'=>'импорт CSV',
                            'route'=>'vpbxui/settings/offdays',
                            'module'     => 'vpbxui',
                            'controller' => 'Vpbxui\Controller\Offday',
                            'action'     => 'import',
                            'resource'   => 'mvc:settingsoffdays.vpbxui', // resource
                            'privilege' => 'import',
                            'visible'    => true, // not visible
                            'pages'=>array(
                        
                            ),                                                
                        ),
                        array(
                            'label' => 'экспорт CSV',
                            'title'=>'экспорт CSV',
                            'route'=>'vpbxui/settings/offdays',
                            'module'     => 'vpbxui',
                            'controller' => 'Vpbxui\Controller\Offday',
                            'action'     => 'export',
                            'resource'   => 'mvc:settingsoffdays.vpbxui', // resource
                            'privilege' => 'export',
                            'visible'    => true, // not visible
                            'pages'=>array(
                        
                            ),
                        ),
                        
                    ),
                    
                ),
                 array(
                    'label' => 'настройки колл-центра',
                    'title'=>'общие настройки',
                    'route' => 'vpbxui/callcentresettings',
                    'privilege' => 'index',
                    'resource'   => 'mvc:settingscallcentre.vpbxui', // resource
                    'controller' => 'Vpbxui\Controller\CallCentreSettings',
                    'action'  => 'index',
                    'pages'=>array(
                    array(
                        'label' => 'расписание',
                        'title'=>'расписание приема вызовов',
                        'route' => 'vpbxui/callcentresettings/schedule',
                        'privilege' => 'index',
                        'resource'   => 'mvc:callcentreschedule.vpbxui', // resource
                        'controller' => 'Vpbxui\Controller\CallCentreSchedule',
                        'action'  => 'index'
                    ),                    
                     )
                ),
                
                array(
                		'label' => 'общие настройки',
                		'title'=>'общие настройки',
                		'route' => 'vpbxui/settings/general',
                		'privilege' => 'index',
                		'resource'   => 'mvc:settingsgeneral.vpbxui', // resource
                		'controller' => 'Vpbxui\Controller\GeneralSettings',
                		'action'  => 'index',
                		'pages'=>array(
                		    array(
                		        'label' => 'диапазон внутренних номеров',
                		        'title'=>'нумерация',
                		        'route' => 'vpbxui/settings/numberallowed',
                		        'privilege' => 'index',
                		        'resource'   => 'mvc:settingsnumberallowed.vpbxui', // resource
                		        'controller' => 'Vpbxui\Controller\NumberAllowed',
                		        'action'  => 'index'                		    
                		    ),
                		    array(
                		        'label' => 'безопасность SIP',
                		        'title'=>'безопасность SIP',
                		        'route' => 'vpbxui/settings/defaultdenypermit',
                		        'privilege' => 'index',
                		        'resource'   => 'mvc:settingsdenypermit.vpbxui', // resource
                		        'controller' => 'Vpbxui\Controller\DefaultDenyPermit',
                		        'action'  => 'index'
                		    ),
                				array(
                						'label' => 'медиа файлы',
                						'title'=>'медиа файлы',
                						'route' => 'vpbxui/settings/media',
                						'privilege' => 'index',
                						'resource'   => 'mvc:settingsmedia.vpbxui', // resource
                						'controller' => 'Vpbxui\Controller\MediaRepos',
                						'action'  => 'index',
                						'pages'=>array(
                								array(
                										'label' => 'добавить',
                										'title'=>'добавить',
                										'route' => 'vpbxui/settings/media',
                										'privilege' => 'add',
                										'resource'   => 'mvc:settingsmedia.vpbxui', // resource
                										'controller' => 'Vpbxui\Controller\MediaRepos',
                										'action'  => 'add',
                								)
                						)
                				),
                
                		)
                ),
                array(
                    'label' => 'настройки телеконференции',
                    'title'=>'настройки телеконференции',
                    'route' => 'vpbxui/settings/conferencesettings',
                    'privilege' => 'index',
                    'resource'   => 'mvc:conferencesettings.vpbxui', // resource
                    'controller' => 'Vpbxui\Controller\ConferenceSettings',
                    'action'  => 'index', 
                   'pages'=>array(
                								array(
                										'label' => 'сбросить по умолчанию',
                										'title'=>'по умолчанию',
                										'route' => 'vpbxui/settings/conferencesettings',
                										'privilege' => 'default',
                										'resource'   => 'mvc:conferencesettings.vpbxui', // resource
                										'controller' => 'Vpbxui\Controller\ConferenceSettings',
                										'action'  => 'default',
                								)
                						)       
                ),
                                
            )
        ),
        'users' => array(
            'label' => 'пользователи',
            'title'=>'меню настройки пользователей',
            
            'route' => 'vpbxui/users',
            'privilege' => 'list',
            'resource'   => 'mvc:users.vpbxui', // resource
            'controller'=>'Vpbxui\Controller\Users',
            'action'=>'index',
        
            'pages'=>
            array(
                array(
                    'label' => 'обзор',
                    'title'=>'просмотр списка пользователей системы',                    
                    'route' => 'zfcadmin/zfcuseradmin/list',
                    'privilege' => 'list',
                    'resource'   => 'mvc:users.vpbxui', // resource
                    'pages'=>array(
                        array(
                            'label' => 'добавить',
                            'title'=>'добавление нового пользователя системы',                            
                            'route' => 'zfcadmin/zfcuseradmin/create',
                            'privilege' => 'add',
                            'resource'   => 'mvc:users.vpbxui', // resource
                        )
                    )
                ),
                array(
                    'label' => 'роли',
                    'title'=>'просмотр списка ролей присвоенных пользователям системы',                    
                    'route' => 'vpbxui/users/roles',
                    'privilege' => 'index',
                    'resource'   => 'mvc:userroles.vpbxui', // resource
                    'controller' => 'Vpbxui\Controller\UserRoles',
                    'action'  => 'index',
                    'pages'=>array(array(
                        'label' => 'изменить',
                        'route' => 'vpbxui/users/roles',
                        'resource'   => 'mvc:userroles.vpbxui', // resource
                        'controller' => 'Vpbxui\Controller\UserRoles',
                        'action'  => 'edit',
                        'visible'    => false, // not visible
                    )
                    )
                ),                              
            )
        ),
        'logout' => array(
                        'visible'=>'false',
        		'label'=>'выход',
        		'route'=>'zfcuser/logout',
        	 'resource'   => 'mvc:logout.vpbxui' // resource
        		    
        ),
        ),
    ));
