<?php
return array(
   
          'router'=>array('routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Dialout',
                        'action'     => 'Index',
                    ),
                ),
            ),
              
            'alarmplay' => array(
          				'type'    => 'Segment',
          				'options' => array(
          						'route' => '/alarmplay[/:action]',
          						'defaults' => array(
          								'controller' => 'PbxAgi\Controller\AlarmPlay',
          								'action' => 'Index'
          						)
          				),
          				'may_terminate' => true
          		),
          		'faxsend' => array(
          				'type'    => 'Segment',
          				'options' => array(
          						'route' => '/faxsend[/:action]',
          						'defaults' => array(
          								'controller' => 'PbxAgi\Controller\FaxSendSender',
          								'action' => 'Index'
          						)
          				),
          				'may_terminate' => true
          		),
          		'parsefaxemail' =>array(
          				'type'    => 'Segment',
          				'options' => array(
          						'route'    => '/parsefaxemail[/:action]',
          						'defaults' => array(
          								'controller'    => 'PbxAgi\Controller\ParseFaxEmail',
          								'action'        => 'Index',
          						),
          				),
          				'may_terminate' => true
          		),
          		
       'callcentre' => array(
                   'type'    => 'Segment',        
                    'options' => array(
                        'route' => '/callcentre[/:action]',
                        'defaults' => array(
                            'controller' => 'DialCallCentre',
                            'action' => 'Index'
                        )
                    ),
               'may_terminate' => true                  
                ),
                                 
               'calloperators' =>array(
                  'type'    => 'Literal',
                  'options' => array(
                      'route'    => '/calloperators',
                      'defaults' => array(
                          'controller'    => 'CallCentre',
                          'action'        => 'Index',
                      ),
                  ),
                  'may_terminate' => true                  
              ),
              
               'record' =>array(
                  'type'    => 'Literal',
                  'options' => array(
                      'route'    => '/record',
                      'defaults' => array(
                          'controller'    => 'RecordCall',
                          'action'        => 'Index',
                      ),
                  ),
                  'may_terminate' => true, 
                   'child_routes'=>array(
                       'recordstop' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/stop',
                            'defaults' => array(
                            'controller'    => 'Record',
                            'action'        => 'Stop',
                            ),
                          ),
                  '      may_terminate' => true      
                       )
                   )
              ),
              
                'channeldown' =>array(
                  'type'    => 'Literal',
                  'options' => array(
                      'route'    => '/channeldown',
                      'defaults' => array(
                          'controller'    => 'ChannelDown',
                          'action'        => 'Index',
                      ),
                  ),
                  'may_terminate' => true                  
              ),

              'answer' =>array(
                  'type'    => 'Literal',
                  'options' => array(
                      'route'    => '/answer',
                      'defaults' => array(
                          'controller'    => 'Answer',
                          'action'        => 'Index',
                      ),
                  ),
                  'may_terminate' => true                  
              ),
              
              'extenreceive' => array(
                  'type'    => 'Segment',
                  'options' => array(
                      'route'    => '/extenreceive[/:action]',
                      'defaults' => array(
                          'controller'    => 'ExtensionReceiveIncoming',
                          'action'        => 'Index',
                      ),
                  ),                  
                  'may_terminate' => true,
              ),
               
                'dialsipexten' => array(
                  'type'    => 'segment',
                  'options' => array(
                      'route'    => '/dialsipexten[/:action]',
                      'constraints'=> array(
                                  ),
                      'defaults' => array(
                          'controller'    => 'DialExtension',
                          'action'        => 'Index',
                      ),
                  ),
                  'may_terminate' => true
               ),

          		
          	'trunkin' => array(
          			'type'    => 'segment',
          			'options' => array(
          					'route'    => '/trunkin[/:action]',
          					'constraints'=> array(
          					),
          					'defaults' => array(
          							'controller'    => 'PbxAgi\Controller\Trunk',
         							'action'        => 'Index',
          					),
          			),
          			'may_terminate' => true
          	),
          		'features' => array(
          				'type'    => 'segment',
          				'options' => array(
          						'route'    => '/features[/:action]',
          						'constraints'=> array(
          						),
          						'defaults' => array(
          								'controller'    => 'PbxAgi\Controller\Feature',
          								'action'        => 'Index',
          						),
          				),
          				'may_terminate' => true
          		),
          		
              'dialin' => array(
                  'type'    => 'segment',
                  'options' => array(
                      'route'    => '/dialin[/:action]',
                      'constraints'=> array(
                                  ),
                      'defaults' => array(
                          'controller'    => 'Dialin',
                          'action'        => 'Index',
                      ),
                  ),
                  'may_terminate' => true
               ),
              
              'faxreceive' => array(
                  'type'    => 'segment',
                  'options' => array(
                      'route'    => '/faxreceive[/:action[:number]]',
                      'constraints'=> array(
                          'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',                          
                      ),
                      'defaults' => array(
                          'controller'    => 'PbxAgi\Controller\FaxReceive',
                          'action'        => 'Index',                          
                      ),
                  ),
                  'may_terminate' => true
              ),          		
             'transfer' => array(
          				'type'    => 'segment',
          				'options' => array(
          						'route'    => '/transfer[/:action]',
          						'constraints'=> array(
          								'action'=>'hangup'
          						),
          						'defaults' => array(
          								'controller'    => 'Transfer',
          								'action'        => 'Index',
          						),
          				),
          				'may_terminate' => true,
          	  ),
              'dialout' => array(
                  'type'    => 'segment',
                  'options' => array(
                      'route'    => '/dialout[/:action]',
                      'constraints'=> array(
                                      'action'=>'hangup'
                                  ),
                      'defaults' => array(
                          'controller'    => 'Dialout',
                          'action'        => 'Index',
                      ),
                  ),                  
                  'may_terminate' => true,
         'child_routes'=>array(                                       
                       'regulardialout' => array(
                          'type'    => 'literal',
                          'options' => array(
                              'route'    => '/regular',
                              'defaults' => array(
                              ),
                          ),                            
                      'may_terminate' => false,                          
                          'child_routes' => array(
                              
                              'shortdial'=>array('type'=>'literal',
                                  'options' => array(
                                      'route'    => '/*30',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\ShortDialFeature',
                                          'action'        => 'index',
                                      ),
                                      'may_terminate' => true,
                                  )),                              
                              
                              
                              'conferencejoin'=>array('type'=>'literal',
                                  'options' => array(
                                      'route'    => '/*90',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\ConferenceController',
                                          'action'        => 'join',
                                      ),
                                      'may_terminate' => true,
                                  )),
                              
                              'conferencecreate'=>array('type'=>'literal',
                                  'options' => array(
                                      'route'    => '/*91',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\ConferenceController',
                                          'action'        => 'create',
                                      ),
                                      'may_terminate' => true,
                                  )),
                              'voicemailmain'=>array('type'=>'literal',
                                  'options' => array(
                                      'route'    => '/*70',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\VoiceMailMain',
                                          'action'        => 'index',
                                      ),
                                      'may_terminate' => true,
                                  )),
                              
                              'pickup'=>array(
                                  'type'=>'segment',
                                  'options' => array(
                                      'route'    => '/*40',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\PickupFeature',
                                          'action'        => 'pickup',
                                      ),
                                      'may_terminate' => true,
                                  )
                              ),

                              'alarmsetup'=>array('type'=>'segment',
                              		'options' => array(
                              				'route'    => '/*50*:time',
                              				'defaults' => array(
                              						'controller'    => 'PbxAgi\Controller\Alarm',
                              						'action'        => 'set',
                              				),
                              				'may_terminate' => true,
                              		)),
                              
                              
                              'setupcallforward'=>array('type'=>'segment',
                                  'options' => array(
                                      'route'    => '/*60*:exten',
                                      'defaults' => array(
                                          'controller'    => 'ForwardFeature',
                                          'action'        => 'setnum',
                                      ),
                                      'may_terminate' => true,
                                      )),
                               'activatecallforward'=>array('type'=>'literal',
                                          'options' => array(
                                              'route'    => '/*61',
                                              'defaults' => array(
                                                  'controller'    => 'ForwardFeature',
                                                  'action'        => 'activate',
                                              ),
                                              'may_terminate' => true,
                                              )),
                                'deactivateactivatecallforward'=>array('type'=>'literal',
                                    'options' => array(
                                        'route'    => '/*62',
                                        'defaults' => array(
                                        'controller'    => 'ForwardFeature',
                                        'action'        => 'deactivate',
                                            ),
                                        'may_terminate' => true,
                                        )),
                             'checkcallforward'=>array('type'=>'literal',
                                 'options' => array(
                                     'route'    => '/*63',
                                     'defaults' => array(
                                         'controller'    => 'ForwardFeature',
                                         'action'        => 'check',
                                     ),
                                     'may_terminate' => true,
                                     )),
                               'dialextension' => array(
                                  'type'    => 'Segment',
                                  'options' => array(
                                  'route'    => '/[:extension]',
                                  'constraints'=> array(
                                      'extension'=>'[0-9]{3}'
                                  ),
                                  'defaults' => array(
                                      'controller'    => 'DialExtension',
                                      'action'        => 'Index',
                                        ),
                                ),                                   
                                'may_terminate' => true,                                   
                               ),
                              
                              'dialpstn' => array(
                                  'type'    => 'Segment',
                                  'options' => array(
                                  'route'    => '/[:extension]',
                                  'constraints'=> array(
                                      'extension'=> '(\d{7,})|(\d{4})'
                                  ),
                                  'defaults' => array(
                                      'controller'    => 'Pstn',
                                      'action'        => 'Index',
                                        ),
                                ),                  
                                'may_terminate' => true,                                   
                               )
                              
                              
                              )
                      ),
                      
                      'operatordialout' => array(
                          'type'    => 'literal',
                          'options' => array(
                              'route'    => '/operator',
                              'defaults' => array(
                              ),
                          ),
                      'may_terminate' => false,
                          'child_routes'=>array(

                              'shortdial'=>array('type'=>'literal',
                                  'options' => array(
                                      'route'    => '/*30',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\ShortDialFeatureController',
                                          'action'        => 'index',
                                      ),
                                      'may_terminate' => true,
                                  )),
                              
                              
                              
                              
                                'conferencejoin'=>array('type'=>'literal',
                                  'options' => array(
                                      'route'    => '/*90',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\ConferenceController',
                                          'action'        => 'join',
                                      ),
                                      'may_terminate' => true,
                                  )),
                              
                              'conferencecreate'=>array('type'=>'literal',
                                  'options' => array(
                                      'route'    => '/*91',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\ConferenceController',
                                          'action'        => 'create',
                                      ),
                                      'may_terminate' => true,
                                  )),                              
                              'voicemailmain'=>array('type'=>'literal',
                                  'options' => array(
                                      'route'    => '/*70',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\VoiceMailMain',
                                          'action'        => 'index',
                                      ),
                                      'may_terminate' => true,
                                  )),
                              
                              
                              'pickup'=>array(
                                  'type'=>'segment',
                                  'options' => array(
                                      'route'    => '/*40',
                                      'defaults' => array(
                                          'controller'    => 'PbxAgi\Controller\PickupFeature',
                                          'action'        => 'pickup',
                                      ),
                                      'may_terminate' => true,
                                  )
                          ),
                              
                              'alarmsetup'=>array('type'=>'segment',
                              		'options' => array(
                              		    'route'    => '/*50*:time',
                              				'defaults' => array(
                              						'controller'    => 'PbxAgi\Controller\Alarm',
                              						'action'        => 'set',
                              				),
                              				'may_terminate' => true,
                              		)),
                              
                              'setupcallforward'=>array('type'=>'segment',
                                  'options' => array(
                                      'route'    => '/*60*:exten',
                                      'defaults' => array(
                                          'controller'    => 'ForwardFeature',
                                          'action'        => 'setnum',
                                      ),
                                      'may_terminate' => true,                                      
                                      )),
                              'activatecallforward'=>array('type'=>'literal',
                                     'options' => array(
                                        'route'    => '/*61',
                                              'defaults' => array(
                                                  'controller'    => 'ForwardFeature',
                                                  'action'        => 'activate',
                                              ),
                                         'may_terminate' => true,
                                         )),
                              'deactivateactivatecallforward'=>array('type'=>'literal',
                                     'options' => array(
                                                      'route'    => '/*62',
                                                      'defaults' => array(
                                                          'controller'    => 'ForwardFeature',
                                                          'action'        => 'deactivate',
                                                      ),
                                         'may_terminate' => true,
                                         )),
                              'checkcallforward'=>array('type'=>'literal',
                                                          'options' => array(
                                                              'route'    => '/*63',
                                                              'defaults' => array(
                                                                  'controller'    => 'ForwardFeature',
                                                                  'action'        => 'check',
                                                              ),
                                           'may_terminate' => true,
                                           )),
                              'dialextension' => array(
                                  'type'    => 'Segment',
                                  'options' => array(
                                  'route'    => '/[:extension]',
                                  'constraints'=> array(
                                      'extension'=>'[0-9][0-9][0-9]'
                                  ),
                                  'defaults' => array(
                                      'controller'    => 'DialExtension',
                                      'action'        => 'Index',
                                        ),
                                ),                  
                                'may_terminate' => true,                                   
                               ),
 
                              'dialpstn' => array(
                                  'type'    => 'Segment',
                                  'options' => array(
                                  'route'    => '/[:extension]',
                                  'constraints'=> array(
                                      'extension'=>'(\d{7,})|(\d{4})'
                                  ),
                                  'defaults' => array(
                                      'controller'    => 'Pstn',
                                      'action'        => 'Index',
                                        ),
                                ),                  
                                'may_terminate' => true,                                   
                               ),
                              
                              'operatorlogin'=>array('type'=>'literal',
                              'options' => array(
                              'route'    => '/*80',
                              'defaults' => array(
                            'controller'    => 'OperatorPresenceFeature',
                            'action'        => 'login',
                                 ),
                                  
                                  )
                                  ),
                              
                            'operatorlogout'=>array('type'=>'literal',
                              'options' => array(
                              'route'    => '/*83',
                              'defaults' => array(
                            'controller'    => 'OperatorPresenceFeature',
                            'action'        => 'logout',
                                 ),                                  
                                  )
                                  ),
                              
                            'operatorloginlunch'=>array('type'=>'literal',
                              'options' => array(
                              'route'    => '/*81',
                              'defaults' => array(
                            'controller'    => 'OperatorPresenceFeature',
                            'action'        => 'lunch',
                                 ),                                  
                                  )
                                  ),
                             
                            
                              'operatorloginbreak' => array('type'=>'literal',
                              'options' => array(
                              'route'    => '/*82',
                              'defaults' => array(
                            'controller'    => 'OperatorPresenceFeature',
                            'action'        => 'break',
                                 ),                                  
                                  )
                                  ),
                           
                          )
  
                      ),
                      
                      'callcentre' => array(
                          'type'    => 'Segment',
                          'options' => array(
                              'route'    => '/[:controller[/:action]]',
                              'constraints' => array(
                                  'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                  'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                              ),
                              'defaults' => array(
                              ),
                          ),
                      ),
                      
                   ),
              ),
              
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                         'controller'    => 'Dialout',
                        'action'        => 'Index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        )),        
     'view_manager' => array(     	 
        'display_exceptions' => true
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
             )
            
        )
    )
    
);
