<?php
return array(
 'zfcadmin' => array(
        'use_admin_layout'      => false,
    ),

    'router' => array(
        'routes' => array(    
            'createconference' => array(
                'type' => 'Segment',
                
                'options' => array(
                    'route' => '/createconference[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                    'defaults' => array(
                        'controller' => 'Vpbxui\Controller\ConferenceBooking',
                        'action' => 'index',
                    ),
                ),
                'may_terminate'=>true
            ),                           
            'zfcuser' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/cabinet',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'login',
                            ),
                        ),
                    ),
                	
                    'authenticate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'authenticate',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/register',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'register',
                            ),
                        ),
                    ),
                    'changepassword' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-password',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'changepassword',
                            ),
                        ),
                        ),
                    ),
                    'changeemail' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-email',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'changeemail',
                            ),
                        ),
                    ),
         ),
         

   
         
     'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Vpbxui\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            
            
            'vpbxui' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/cabinet',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Vpbxui\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                		'registerpbx' => array(
                				'type' => 'Literal',
                				'options' => array(
                						'route' => '/registerpbx',
                						'defaults' => array(
                								'controller' => 'Vpbxui\Controller\RegisterPbx',
                								'action'     => 'index',
                						),
                				),
                				'may_terminate'=>true
                		),
                'internal' => array(
                		'type'    => 'segment',
                		'options' => array(
                				'route'    => '/internal[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                				'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                				),
                				'defaults' => array(
                						'controller' => 'Vpbxui\Controller\Internal',
                						'action'     => 'index',
                				),
                		),
                ),
                		
               'callcentresettings'=>array(
                				'type'=>'literal',
               		'options' => array(
               				'route'    => '/callcentresettings',
               				'defaults' => array(
               						'controller'    => 'Vpbxui\Controller\CallCentreSettings',
               						'action'        => 'index',
               				),
               		),
               		'may_terminate' => true,
               		'child_routes' => array(
               				'schedule' => array(
               						'type'    => 'segment',
               						'options' => array(
               								'route'    => '/schedule[/:action]',
               								'constraints' => array(
               										'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
               								),
               								'defaults' => array(
               										'controller' => 'Vpbxui\Controller\CallCentreSchedule',
               										'action'     => 'index',
               								),
               						),
               						'may_terminate'=>true
               			),
               			)
                ),		
                 
                 'callcentre' => array(
               'type'    => 'literal',
                'options' => array(
                    'route'    => '/callcentre',
                    'defaults' => array(
                         'controller'    => 'Vpbxui\Controller\Callcentre',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(

                'monitoring' => array(
                    'type' => 'segment',
                    'options' => array(
                        'route' => '/monitoring[/:action][/:state]',
                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'state' => 'default|enable|disable',                            
                        ),
                        'defaults' => array(
                            'controller' => 'Vpbxui\Controller\Monitoring',
                            'action'     => 'index',
                        ),                
                    ),
                    'may_terminate' => true,                
                ),                                
                 'stats' => array(
               'type'    => 'literal',
                'options' => array(
                    'route'    => '/stats',
                    'defaults' => array(
                         'controller'    => 'Vpbxui\Controller\CallCentreStats',
                        'action'        => 'index',
                    ),
                ),                  
                     'may_terminate' => true,
                    'child_routes' => array(
                                                                                                                                                                                                    
                           
                            
                      'operators' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/operators',
                                    'defaults' => array(
                                        'controller' => 'Vpbxui\Controller\CallCentreStatsOperators',
                                        'action'     => 'index',
                                    ),                                    
                                ),
                                'may_terminate' => true,
                                'child_routes'=>array(
                                    'missed' => array(
                		                  'type'    => 'segment',
                		                  'options' => array(
  				                          'route'    => '/missed[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                				            'constraints' => array(
                                                     'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id'     => '[0-9]+',
                                                        'page' => '[0-9]+',
                                                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'order' => 'ASC|DESC',
                				),                				
                                                        'defaults' => array(
                                                        'controller' => 'Vpbxui\Controller\CdrMissedCallsCallCentre',
                					'action'     => 'index',
                				),
                		          ),
                                'may_terminate' => true
                                ),
                                )
                         ),
                                            
                  ),
                  ),
                    ),
                     ),
          
                
                
                    'settings' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/settings',
                             'defaults' => array(
                                'controller' => 'Vpbxui\Controller\Settings',
                                'action'     => 'index',
                            ),
                            
                        ),
                           'may_terminate' => true,
                           'child_routes' => array(

                           'extensiondefaults' => array(
                           		'type' => 'Segment',
                           				 
                           		'options' => array(
                           				'route' => '/extensiondefaults',
                           					'defaults' => array(
                           						'controller' => 'Vpbxui\Controller\ExtensionDefaults',
                           						'action' => 'edit',
                           					),
                           				),
                           				'may_terminate'=>true
                           		),
              
                           'skypealias' => array(
                           		'type' => 'Segment',
                           
                           		'options' => array(
                           				'route' => '/skypealias[/:action][/:id]',
                           				'constraints' => array(
                           						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                           						'id'     => '[0-9]+',                           						 
                           				),
                           				'defaults' => array(
                           						'controller' => 'Vpbxui\Controller\SkypeAlias',
                           						'action' => 'index',
                           				),
                           		),
                           		'may_terminate'=>true
                           ),

                           	'authcode' => array(
                           				'type' => 'Segment',
                           				 
                           				'options' => array(
                           						'route' => '/authcode[/:action][/:id]',
                           						'constraints' => array(
                           								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                           								'id'     => '[0-9]+',
                           						),
                           						'defaults' => array(
                           								'controller' => 'Vpbxui\Controller\AuthCode',
                           								'action' => 'index',
                           						),
                           				),
                           				'may_terminate'=>true
                           ),
                           		
                           		
                          'trunk' => array(
                           	 'type' => 'Segment',
                            				'options' => array(
                           						'route' => '/trunk[/:action][/:id]',
                           						'constraints' => array(
                           								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                           								'id'     => '[0-9]+',
                           						),
                           						'defaults' => array(
                           								'controller' => 'Vpbxui\Controller\Trunk',
                           								'action' => 'index',
                           						),
                           				),
                           				'may_terminate'=>true
                           		),
                           		'context' => array(
                           				'type' => 'Segment',
                           				'options' => array(
                           						'route' => '/context[/:action][/:id]',
                           						'constraints' => array(
                           								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                           								'id'     => '[0-9]+',
                           						),
                           						'defaults' => array(
                           								'controller' => 'Vpbxui\Controller\Context',
                           								'action' => 'index',
                           						),
                           				),
                           				'may_terminate'=>true
                           		),
                           		
                           		'ivr' => array(
                           				'type' => 'Segment',
                           				'options' => array(
                           						'route' => '/ivr[/:action][/:id]',
                           						'constraints' => array(
                           								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                           								'id'     => '[0-9]+',
                           						),
                           						'defaults' => array(
                           								'controller' => 'Vpbxui\Controller\Ivr',
                           								'action' => 'index',
                           						),
                           				),
                           				'may_terminate'=>true
                           		),
                           		'route' => array(
                           				'type' => 'Segment',
                           				'options' => array(
                           						'route' => '/route[/:action][/:id]',
                           						'constraints' => array(
                           								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                           								'id'     => '[0-9]+',
                           						),
                           						'defaults' => array(
                           								'controller' => 'Vpbxui\Controller\Route',
                           								'action' => 'index',
                           						),
                           				),
                           				'may_terminate'=>true
                           		),                           		 
                           		'filter' => array(
                           				'type' => 'Segment',
                           				'options' => array(
                           						'route' => '/filter[/:action][/:id]',
                           						'constraints' => array(
                           								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                           								'id'     => '[0-9]+',
                           						),
                           						'defaults' => array(
                           								'controller' => 'Vpbxui\Controller\NumberMatch',
                           								'action' => 'index',
                           						),
                           				),
                           				'may_terminate'=>true
                           		),             
                           		'faxuser' => array(
                           				'type' => 'Segment',
                           				'options' => array(
                           						'route' => '/faxuser[/:action][/:id]',
                           						'constraints' => array(
                           								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                           								'id'     => '[0-9]+',
                           						),
                           						'defaults' => array(
                           								'controller' => 'Vpbxui\Controller\FaxUser',
                           								'action' => 'index',
                           						),
                           				),
                           				'may_terminate'=>true
                           		),
                           		 
                            'profile' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/profile',
                                    'defaults' => array(
                                        'controller' => 'Vpbxui\Controller\Settings',
                                        'action'     => 'group',
                                    ),
                                    ),
                                    'may_terminate' => false,
                                    'child_routes' => array(
                                'internal' => array(
                                    'type'    => 'segment',
                                    'options' => array(
                                        'route'    => '/internal[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                                        'constraints' => array(
                                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                            'id'     => '[0-9]+',
                                            'page' => '[0-9]+',
                                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            'order' => 'ASC|DESC',
                                        ),
                                        'defaults' => array(
                                            'controller' => 'Vpbxui\Controller\InternalProfile',
                                            'action'     => 'index',
                                        ),
                                    ),
                                ),

                             
                                 'group' => array(
                                    'type'    => 'segment',
                                    'options' => array(
                                        'route'    => '/group[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                                        'constraints' => array(
                                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                            'id'     => '[0-9]+',
                                            'page' => '[0-9]+',
                                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            'order' => 'ASC|DESC',
                                        ),
                                        'defaults' => array(
                                            'controller' => 'Vpbxui\Controller\InternalGroupProfile',
                                            'action'     => 'index',
                                        ),
                                        ),
                                    ),
                                ),
                                                                                                
                                ),
                                                                                                  
                           'groups' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/groups',
                                    'defaults' => array(
                                    'controller' => 'Vpbxui\Controller\Settings',
                                   'action'     => 'groups',
                                    ),                           
                                ),
                                'may_terminate'=>true,
                                'child_routes'=>array(
                                'internal' => array(
                                    'type'    => 'segment',
                                    'options' => array(
                                        'route'    => '/internal[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                                        'constraints' => array(
                                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                            'id'     => '[0-9]+',
                                            'page' => '[0-9]+',
                                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            'order' => 'ASC|DESC',
                                        ),
                                        'defaults' => array(
                                            'controller' => 'Vpbxui\Controller\ExtensionGroup',
                                            'action'     => 'index',
                                        ),
                                    ),
                                ),
                                 
                                'pickup' => array(
                                    'type'    => 'segment',
                                    'options' => array(
                                        'route'    => '/pickup[/:action][/:name][/page/:page][/order_by/:order_by][/:order]',
                                        'constraints' => array(
                                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                            'name' => '[0-9]+',                                            
                                            'page' => '[0-9]+',
                                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            'order' => 'ASC|DESC',
                                        ),
                                        'defaults' => array(
                                            'controller' => 'Vpbxui\Controller\PickupGroup',
                                            'action'     => 'index',
                                        ),
                                    ),
                                ),
                                ),
                                ),

                                'offdays' => array(
                                    'type'    => 'segment',
                                    'options' => array(
                                        'route'    => '/offdays[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                                        'constraints' => array(
                                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                            'id'     => '[0-9]+',
                                            'page' => '[0-9]+',
                                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            'order' => 'ASC|DESC',                                            
                                            'startdate' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            'enddate' => '[a-zA-Z][a-zA-Z0-9_-]*',                                            
                                        ),
                                        'defaults' => array(
                                            'controller' => 'Vpbxui\Controller\Offday',
                                            'action'     => 'index',
                                        ),
                                    ),
                                    'may_terminate' => true
                                ),
                                'general' => array(
                                    'type'    => 'segment',
                                    'options' => array(
                                        'route'    => '/general[/:action]',
                                        'constraints' => array(
                                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        ),
                                        'defaults' => array(
                                            'controller' => 'Vpbxui\Controller\GeneralSettings',
                                            'action'     => 'index',
                                        ),
                                    ),
                                'may_terminate'=>true
                                ),
                                
                                'media' => array(
                                    'type'    => 'segment',
                                    'options' => array(
                                        'route'    => '/media[/:action][/:id]',
                                        'constraints' => array(
                                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            'id'     => '[0-9]+',                                          
                                        ),
                                        'defaults' => array(
                                            'controller' => 'Vpbxui\Controller\MediaRepos',
                                            'action'     => 'index',
                                        ),
                                    ),
                                    'may_terminate' => true
                                ),
                                
                                ),                                
                                                                
                        ),
                
              
                                                   
                'cdr' => array(
                		'type'    => 'segment',
                		'options' => array(
  				'route'    => '/cdr[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/like_by/:like_by][/:like]',
                				'constraints' => array(
                                                     'action' => '(?!\bpage\b)(?!\blike_by\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id'     => '[0-9]+',
                                                        'page' => '[0-9]+',
                                                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'order' => 'ASC|DESC',
                                                        'like_by' => '[a-zA-Z][a-zA-Z0-9_-]*',                                                        
                                                        'like' => '[a-zA-Z0-9_-]*',                                                        
                                                                                                                    
                				),                				
                                                        'defaults' => array(
                                                        'controller' => 'Vpbxui\Controller\Cdr',
                					'action'     => 'index',
                				),
                		),
                    'may_terminate' => true
                ),
                
                'users' => array(
                		'type'    => 'segment',
                		'options' => array(
                				'route'    => '/users[/:action][/:oid]',
                				'constraints' => array(
                						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                				),
                				'defaults' => array(
                						'controller' => 'Place\Controller\State',
                						'action'     => 'index',
                				),
                		),
                ),                
                                 
                'monitoring' => array(
                		'type'    => 'segment',
                		'options' => array(
                				'route'    => '/monitoring[/:action][/:oid]',
                				'constraints' => array(
                						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                				),
                				'defaults' => array(
                						'controller' => 'Vpbxui\Controller\MonitoringController',
                						'action'     => 'index',
                				),
                		),
                ),
                 'users' => array(
                		'type'    => 'literal',
                		'options' => array(
                				'route'    => '/users',
                				'defaults' => array(
                						'controller' => 'Vpbxui\Controller\Users',
                						'action'     => 'index',
                				),
                		),
                		'may_terminate' => true,                		
                		'child_routes'=>array
                		(
                		'user' => array(
                 		    'type'    => 'segment',
                 		    'options' => array(
                 		        'route'    => '/user[/:action][/:oid]',
                 		        'constraints' => array(
                 		            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                 		        ),
                 		        'defaults' => array(
                 		            'controller' => 'Vpbxui\Controller\Users',
                 		            'action'     => 'index',
                 		        ),
                 		    ),
                 		    'may_terminate'=>true,
                 		),
                		  'roles' => array(
                		      'type'    => 'segment',
                		      'options' => array(
                		          'route'    => '/roles[/:action][/:user_id][/page/:page][/order_by/:order_by][/:order]',
                		          'constraints' => array(
                		              'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                		              'user_id'     => '[0-9]+',
                		              'page' => '[0-9]+',
                		              'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                		              'order' => 'ASC|DESC',
                		          ),
                		          'defaults' => array(
                		              'controller' => 'Vpbxui\Controller\UserRoles',
                		              'action'     => 'index',
                		          ),
                		      ),
                		      'may_terminate'=>true,                		      
                		)
                		  )
                		)
                ),
                
                    
                ),
            ),
        ),
  
   'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
         'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'paginator-slide'         =>  __DIR__ . '/../view/layout/slidePaginator.phtml',
            'paginator-slideCdr'         =>  __DIR__ . '/../view/layout/slidePaginatorCdr.phtml',
            'paginator-slideCdrMissed' =>  __DIR__ . '/../view/layout/slidePaginatorCdrMissed.phtml',
            'paginator-slideOffday' =>  __DIR__ . '/../view/layout/slidePaginatorOffday.phtml',            
	    	'zfcadmin/admin'	      => 'layout',
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'vpbxui/index/index' => __DIR__ . '/../view/vpbxui/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'vpbxui/navigation/topnav.phtml' => __DIR__.'/../view/vpbxui/navigation/topnav.phtml',
            'download/download-csv' => __DIR__ . '/../view/vpbxui/download/download-csv.phtml',
            'extensionFormPartial.phtml' => __DIR__ . '/../view/vpbxui/internal/extensionform.phtml',
        	'extensionGroupFormPartial.phtml'=>  __DIR__ . '/../view/vpbxui/extension-group/extensiongroupform.phtml',
        	'extensionDefaultsFormPartial.phtml'=>  __DIR__ . '/../view/vpbxui/extension-defaults/extensiondefaultsform.phtml',
        	'cdrSearchFormPartial.phtml'=>  __DIR__ . '/../view/vpbxui/cdr/cdrsearchform.phtml',        		
         	'contextFormPartial.phtml' => __DIR__ . '/../view/vpbxui/context/contextform.phtml',       		
        	'routeFormPartial.phtml' => __DIR__ . '/../view/vpbxui/route/routeform.phtml',        
        	'filterFormPartial.phtml' => __DIR__ . '/../view/vpbxui/number-match/filterform.phtml',        		
            'bootstrapModal' => __DIR__ . '/../view/layout/bootstrapModal.phtml', 
            'flashMessengerPartial' => __DIR__ . '/../view/layout/flashMessengerPartial.phtml',    
        	'faxUserFormPartial.phtml' => __DIR__ . '/../view/vpbxui/fax-user/faxuserform.phtml',
        	'dayPartial.phtml' => __DIR__ . '/../view/vpbxui/call-centre-schedule/daypartial.phtml',
        	'offdayFormPartial.phtml' => __DIR__ . '/../view/vpbxui/offday/offdayform.phtml',
        	'playboxPartial.phtml'=> __DIR__ .'/../view/vpbxui/cdr/playboxPartial.phtml',
        	'cdrplayercontainer.phtml' => 	__DIR__ .'/../view/vpbxui/cdr/cdrplayercontainer.phtml',
        	'callsperpeerPartial.phtml' => 	__DIR__ .'/../view/vpbxui/monitoring/callsperpeerPartial.phtml',
        	'scheduleleverwidgetPartial.phtml' 	=> __DIR__ .'/../view/vpbxui/monitoring/scheduleleverwidgetPartial.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'subNavigation' => 'Vpbxui\View\Helper\SubNavigation',
            'operatorStatusDebrief' => 'Vpbxui\View\Helper\OperatorStatusDebrief',
            'cdrScopeDebrief' => 'Vpbxui\View\Helper\CdrScopeDebrief',           
            'callCentreStatusOverrideActiveLink'=>'Vpbxui\View\Helper\ActiveCallCentreStatusProperty',
            'callCentreCallAcceptionStatusDebrief'=>'Vpbxui\View\Helper\CallCentreCallAcceptionStatusDebrief',
            'mediaClassDebrief' => 'Vpbxui\View\Helper\MediaClassDebrief',        
        	'operatorAvailSquare' => 'Vpbxui\View\Helper\OperatorAvailSquare',
        	'cdrDurationSecDebrief' => 'Vpbxui\View\Helper\CdrDurationSecDebrief',       		
        	'dispositionDebrief' => 'Vpbxui\View\Helper\DispositionDebrief',	
        	'registrationStateRowClassResolver' => 'Vpbxui\View\Helper\RegistrationStateRowClassResolver',
        	'registrationRegistrationtimeConverter' => 'Vpbxui\View\Helper\RegistrationRegistrationtimeConverter',		
        	'dispositionDebrief' => 'Vpbxui\View\Helper\DispositionDebrief',
        	'cdrCallDirection' => 'Vpbxui\View\Helper\CdrCallDirection',
        	'cdrCallDateFormat' => 	'Vpbxui\View\Helper\CdrCallDateFormat',
        	'channelStateDebrief' => 'Vpbxui\View\Helper\ChannelStateDebrief',
        	'cdrDstNumReplacementSpecialCase' => 'Vpbxui\View\Helper\CdrDstNumReplacementSpecialCase'
        ),
    ),
);

