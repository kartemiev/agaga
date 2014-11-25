<?php

return array(
    'bjyauthorize' => array(

         
        'default_role' => 'guest',
 
        'identity_provider' => 'BjyAuthorize\Provider\Identity\ZfcUserZendDb',
 
        'role_providers' => array(

             
            'BjyAuthorize\Provider\Role\Config' => array(
                'guest' => array(),
                'user'  => array('children' => array(
                    'admin' => array(),
                    'supervisor' => array(),                    
                )),
            ),
 
            'BjyAuthorize\Provider\Role\ZendDb' => array(
                'table'             => 'user_role',
                'role_id_field'     => 'role_id',
                'parent_role_field' => 'parent',
            ),
 
        ),

         
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                    'mvc:login.vpbxui' => array(),
                    'mvc:internalnumber.vpbxui' => array(), 
                    'mvc:extensiongroup.vpbxui' => array(),       
                    'mvc:settingsgroups.vpbxui' => array(),
                    'mvc:settings.vpbxui' => array(),                
                    'mvc:callcentre.vpbxui'  => array(
                    'mvc:callcentremonitoring.vpbxui',
                    'mvc:callcentrestats.vpbxui',
                    'mvc:callcentrestatsgeneral.vpbxui',
                    'mvc:callcentrestatsoperators.vpbxui',
                    'mvc:callcentreinternaloperators.vpbxui',
                    'mvc:callcentresettings.vpbxui',     
                    'mvc:vpbxwizard.saas'  
                    		
                  ),  
                  'mvc:trunks.vpbxui'  => array(), 
                 'mvc:stats.vpbxui'  => array(),                
                 'mvc:cdr.vpbxui'  => array(), 
            	 'mvc:cdrfind.vpbxui'  => array(),          		
                'mvc:users.vpbxui'=> array(),
                'mvc:settingsinternalprofile.vpbxui' => array(),        
                'mvc:settingsinternalgroupsprofile.vpbxui' => array(),                
            	'mvc:settingsskypealias.vpbxui' => array(),
            	'mvc:settingstrunks.vpbxui' => array(),            		
                'mvc:settingsoffdays.vpbxui' => array(),
            	'mvc:settingscontext.vpbxui' => array(),
            	'mvc:settingsroute.vpbxui' => array(),   
            	'mvc:settingsfaxuser.vpbxui' => array(),            		
            	'mvc:settingsivr.vpbxui' => array(),       
            	'mvc:settingsfilter.vpbxui' => array(),            		
                'mvc:settingsgeneral.vpbxui',
                'mvc:settingsextensiondefaults.vpbxui',
                'mvc:settingsmedia.vpbxui',                 
                'mvc:userroles.vpbxui' => array(),
          		'mvc:settingsauthcode.vpbxui'=>array(),
                'mvc:logout.vpbxui',
                'mvc:conferencecreate.vpbxui',
            	'mvc:settingscallcentre.vpbxui',
            	'mvc:callcentreschedule.vpbxui',		  
            	'mvc:asterreboot.vpbxui',     
            	'mvc:registerpbx.vpbxui',
                'mvc:settingsnumberallowed.vpbxui',
                'mvc:settingsdenypermit.vpbxui'
            ),
        ),

         
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                   
                    array(array('guest'), 'mvc:login.vpbxui',                        
                        
                ),
                    array(array('guest'), 'mvc:conferencecreate.vpbxui',
                    
                    ),
                		array(array('guest'), 'mvc:registerpbx.vpbxui',
                		
                		),
                    array(array('admin'), 
                        'mvc:internalnumber.vpbxui',                   
                     ),                
                    array(array('admin'),
                        'mvc:extensiongroup.vpbxui',
                    ),
                    array(array('admin'), 
                        'mvc:callcentre.vpbxui',                                                              
                    ),                                           
                    
                    array(array('admin'), 
                         'mvc:stats.vpbxui',                      
                     ),

                    array(array('admin'),
                        'mvc:settings.vpbxui',
                    ),
                    
                    array(array('admin'),
                        'mvc:settingsgroups.vpbxui',
                    ),                    
                    
                    array(array('admin'), 
                         'mvc:cdr.vpbxui',
                     ),
                	array(array('admin'),
                		 'mvc:cdrfind.vpbxui',
                	),
                		
                     
                    array(array('admin'), 
                         'mvc:users.vpbxui',
                     ),

                    array(array('admin'),
                        'mvc:logout.vpbxui',
                    ),
                    array(array('admin'),
                        'mvc:userroles.vpbxui',
                    ),
                    
                    array(array('admin'),
                        'mvc:settingsinternalprofile.vpbxui',
                    ),
                    
                    array(array('admin'),
                        'mvc:settingsinternalgroupsprofile.vpbxui',
                    ),                     
                	array(array('admin'),
                		'mvc:settingsskypealias.vpbxui',
                	),
                	array(array('admin'),
                		'mvc:settingstrunks.vpbxui',
                	),   
                	array(array('admin'),
                		'mvc:settingsfaxuser.vpbxui',
                	),                		 
                	array(array('admin'),
                		'mvc:settingscontext.vpbxui',
                	),
                	array(array('admin'),
                		'mvc:settingsroute.vpbxui',
                	),
                	array(array('admin'),
                		'mvc:settingsivr.vpbxui',
                	),                		
                	array(array('admin'),
                		'mvc:settingsfilter.vpbxui',
                	),                		
                    array(array('admin'),
                        'mvc:settingsoffdays.vpbxui',
                    ),
                    array(array('admin'),
                        'mvc:settingsgeneral.vpbxui',
                    ),
                	array(array('admin'),
                		'mvc:settingsextensiondefaults.vpbxui',
                	),
                		 
                   array(array('admin'),
                		'mvc:settingsauthcode.vpbxui',
                	),
                    array(array('admin'),
                        'mvc:settingsmedia.vpbxui',
                    ),
                    array(array('admin'),
                         'mvc:settingsnumberallowed.vpbxui',
                    ),
                    array(array('admin'),
                        'mvc:settingsdenypermit.vpbxui',
                    ),
        
                		array(array('admin'),
                				'mvc:settingscallcentre.vpbxui',
                		),
                		array(array('admin'),
                				'mvc:callcentreschedule.vpbxui',
                		),
                		
                		array(array('admin'),
                				'mvc:callcentremonitoring.vpbxui',
                		),
                		array(array('admin'),
                				'mvc:asterreboot.vpbxui',
                		),
                    
                    array(array('supervisor'),  
                        'mvc:callcentre.vpbxui'                                               
                    ),
                		array(array('guest'),
                				'mvc:vpbxwizard.saas'
                		),
                		
                      array(array('supervisor'),        
                        'mvc:cdr.vpbxui',
                        array('list')                        
                    ),
                	array(array('supervisor'),
                		'mvc:cdrfind.vpbxui',
                	),
                		
                    array(array('supervisor'),                                       
                        'mvc:stats.vpbxui',
                        array('list')                        
                    ),
                    array(array('supervisor'),
                        'mvc:logout.vpbxui',
                    )),
                'deny' => array(
                    // ...
                ),
           ),
            ),
            
         
        'guards' => array(
             
            'BjyAuthorize\Guard\Controller' => array(
                 array(
                    'controller' => array('zfcuser','Vpbxui\Controller\Index',
                    'Vpbxui\Controller\ConferenceBooking',
                    'Saas\Controller\PickDid',                    		
                    'Vpbxui\Controller\RegisterPbx',
                   'Saas\Controller\InternalApi'                    		
                    ),
                     'roles' => array('guest')
                ), 
                
                array(
                    'controller' => array(                        
                        'Vpbxui\Controller\Index',
                        'Vpbxui\Controller\Internal',
                        'Vpbxui\Controller\ExtensionGroup',
                        'Vpbxui\Controller\PickupGroup',                        
                        'Vpbxui\Controller\Monitoring',
                        'Vpbxui\Controller\Settings',
                        'Vpbxui\Controller\Cdr',
                        'Vpbxui\Controller\Users',
                        'Vpbxui\Controller\Callcentre',
                        'Vpbxui\Controller\CallCentreStats',
                        'Vpbxui\Controller\CallCentreStatsGeneral',
                        'Vpbxui\Controller\CallCentreStatsOperators',                        
                        'Vpbxui\Controller\CallCentreMonitoring',      
                        'Vpbxui\Controller\CdrMissedCallsCallCentre',
                        'Vpbxui\Controller\Users',
                        'Vpbxui\Controller\UserRoles',  
                        'Vpbxui\Controller\InternalProfile',
                        'Vpbxui\Controller\InternalGroupProfile',
                    	'Vpbxui\Controller\SkypeAlias',
                    	'Vpbxui\Controller\Trunk',                    		
                    	'Vpbxui\Controller\Context',
                    	'Vpbxui\Controller\Ivr',                    		
                    	'Vpbxui\Controller\Route', 
                    	'Vpbxui\Controller\NumberMatch',                   		
                        'Vpbxui\Controller\GeneralSettings',
                        'Vpbxui\Controller\NumberAllowed',
                        'Vpbxui\Controller\Offday', 
                    	'Vpbxui\Controller\ExtensionDefaults',                  		         
                    	'Vpbxui\Controller\FaxUser',	       
                    	'Vpbxui\Controller\CallCentreSettings',
                    	'Vpbxui\Controller\CallCentreSchedule',
                    	'Vpbxui\Controller\AuthCode',
                        'Vpbxui\Controller\NumberAllowed',
                        'Vpbxui\Controller\DefaultDenyPermit',                        
                        'zfcuseradmin',
                        'zfcuser',
                        'Saas\Controller\CreateVpbxEnv',
                        'Restful\Controller\VpbxEnv'                    		
                        ),
                     'roles' => array('admin')
                ),                
                array(
                    'controller' => array(
                        'Vpbxui\Controller\Index',
                        'Vpbxui\Controller\Internal',
                        'Vpbxui\Controller\Settings',                        
                        'Vpbxui\Controller\ExtensionGroup',
                    	'Vpbxui\Controller\SkypeAlias',  
                    	'Vpbxui\Controller\ExtensionDefaults',                    		
                    	'Vpbxui\Controller\Trunk',                    		
                    	'Vpbxui\Controller\Context',
                    	'Vpbxui\Controller\Ivr',
                    	'Vpbxui\Controller\Route',
                    	'Vpbxui\Controller\NumberMatch',                    		
                        'Vpbxui\Controller\PickupGroup',                        
                    	'Vpbxui\Controller\FaxUser',      
                    	'Vpbxui\Controller\CallCentreSettings',
                    	'Vpbxui\Controller\CallCentreSchedule',                      		
                        'zfcuser'
                        ),
                    'action' => array('index','search','logout','groups'),
                    'roles' => array('supervisor','admin')
                ),                               
                array(
                    'controller' => array(
                        'Vpbxui\Controller\Stats',
                        'Vpbxui\Controller\Monitoring',
                        'Vpbxui\Controller\Callcentre',
                        'Vpbxui\Controller\CallCentreStats',
                        'Vpbxui\Controller\CallCentreStatsGeneral',
                        'Vpbxui\Controller\CallCentreStatsOperators',
                        'Vpbxui\Controller\CdrMissedCallsCallCentre',
                        'Vpbxui\Controller\GeneralSettings', 
                    	'Vpbxui\Controller\SkypeAlias', 
                    	'Vpbxui\Controller\Trunk',    
                    	'Vpbxui\Controller\Context',
                    	'Vpbxui\Controller\Ivr',                    		
                    	'Vpbxui\Controller\Route',      
                    	'Vpbxui\Controller\NumberMatch',                    		
                        'Vpbxui\Controller\Cdr',
                        'Vpbxui\Controller\Offday',        
                        'Vpbxui\Controller\MediaRepos',
                        'Vpbxui\Controller\ExtensionDefaults', 
                    	'Vpbxui\Controller\FaxUser',  
                    	'Vpbxui\Controller\CallCentreSettings',
                    	'Vpbxui\Controller\CallCentreSchedule'                  		                    		
                    ),
                     'roles' => array('supervisor','admin')
                ),
                 array(
                    'controller' => array(
                        'zfcuser',
                    ),
                     'action' => array('login'),
                     'roles' => array('guest')
                ),
                array(
                    'controller' => array(
                        'Vpbxui\Controller\Index',
                    	'Vpbxui\Controller\RegisterPbx',
                    	'Saas\Controller\VpbxWizard',	
                    	'Saas\Controller\CreateInternal',	
                        'Saas\Controller\InternalApi',
                        'Restful\Controller\WizardFreeDid',
                        'Saas\Controller\PlayTmpMedia',
                        'Saas\Controller\Captcha',
                        'Saas\Controller\NumberAllowed',
                        'Restful\Controller\WizardMediaDefault'                    		
                     ),
                     'roles' => array('guest')
                ),
             ),

            
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'zfcuser/login', 'roles' => array('guest')),
                array('route' => 'playtmpmedia', 'roles' => array('guest')),
                array('route' => 'numberallowed', 'roles' => array('guest')),
                
            	array('route' => 'vpbxui/registerpbx', 'roles' => array('guest')),
                array('route' => 'api/freedid', 'roles' => array('guest')),
                array('route' => 'api/mediadefault', 'roles' => array('guest')),

                array('route' => 'api/vpbxenv', 'roles' => array('admin')),
                
                array('route' => 'createconference', 'roles' => array('guest')),    
            		array('route' => 'pickdid', 'roles' => array('guest')),
            		array('route' => 'wizard', 'roles' => array('guest')),
            		array('route' => 'createinternal', 'roles' => array('guest')),
            		array('route' => 'internalapi', 'roles' => array('guest')),
                array('route' => 'captcha', 'roles' => array('guest')),                
                array('route' => 'createvpbx', 'roles' => array('admin')),
                
            		
                array('route' => 'home', 'roles' => array('admin','supervisor','guest')),
                array('route' => 'vpbxui/default', 'roles' => array('admin','supervisor')),
                array('route' => 'vpbxui/internal', 'roles' => array('admin')),
                array('route' => 'vpbxui/extensiongroup', 'roles' => array('admin')),                
                array('route' => 'vpbxui/callcentre', 'roles' => array('admin','supervisor')),
                array('route' => 'vpbxui/callcentre/stats', 'roles' => array('admin','supervisor')),
                array('route' => 'vpbxui/callcentre/monitoring', 'roles' => array('admin','supervisor')),
                array('route' => 'vpbxui/callcentre/stats/operators', 'roles' => array('admin','supervisor')),             
                array('route' => 'vpbxui/callcentre/stats/operators/missed', 'roles' => array('admin','supervisor')),
                
                array('route' => 'vpbxui/cdr', 'roles' => array('admin','supervisor')),
                array('route' => 'vpbxui/settings','roles' => array('admin')),
                array('route' => 'vpbxui/settings/groups','roles' => array('admin')),
                array('route' => 'vpbxui/settings/groups/internal','roles' => array('admin')),
                array('route' => 'vpbxui/settings/groups/pickup','roles' => array('admin')),
            	array('route' => 'vpbxui/settings/authcode','roles' => array('admin')),
            		
                array('route' => 'vpbxui/settings/profile/group', 'roles' => array('admin')),
            	array('route' => 'vpbxui/settings/profile/internal', 'roles' => array('admin')),            		
            	array('route' => 'vpbxui/settings/skypealias', 'roles' => array('admin')),     
            	array('route' => 'vpbxui/settings/trunk', 'roles' => array('admin')),            		
            	array('route' => 'vpbxui/settings/context', 'roles' => array('admin')),
            	array('route' => 'vpbxui/settings/ivr', 'roles' => array('admin')),            		            	
            	array('route' => 'vpbxui/settings/route', 'roles' => array('admin')),            		
            	array('route' => 'vpbxui/settings/filter', 'roles' => array('admin')),            		
                array('route' => 'vpbxui/settings/offdays', 'roles' => array('admin')),
                array('route' => 'vpbxui/settings/general', 'roles' => array('admin')),
                array('route' => 'vpbxui/settings/media', 'roles' => array('admin')),
                array('route' => 'vpbxui/settings/numberallowed', 'roles' => array('admin')),
                array('route' => 'vpbxui/settings/defaultdenypermit', 'roles' => array('admin')),
                
                array('route' => 'vpbxui/settings/extensiondefaults', 'roles' => array('admin')),                
            	array('route' => 'vpbxui/settings/faxuser', 'roles' => array('admin')),

            	array('route' => 'vpbxui/callcentresettings', 'roles' => array('admin')),            		
            	array('route' => 'vpbxui/callcentresettings/schedule', 'roles' => array('admin')),
            		
                array('route' => 'vpbxui/users', 'roles' => array('admin')),
                array('route' => 'vpbxui/users/roles', 'roles' => array('admin')),
                
                array('route' => 'zfcadmin/zfcuseradmin/list', 'roles' => array('admin')),
                array('route' => 'zfcadmin/zfcuseradmin/create', 'roles' => array('admin')),
                array('route' => 'zfcadmin/zfcuseradmin/edit', 'roles' => array('admin')),
                array('route' => 'zfcadmin/zfcuseradmin/remove', 'roles' => array('admin')),                
                array('route' => 'zfcuser/logout', 'roles' => array('admin', 'supervisor'))
            		

            ),
         ),
                ),
);