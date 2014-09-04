<?php
return array(
    'modules' => array(
    	'ZfcBase',
        'ZfcUser',
		'ZfcAdmin',
		'ZfcUserAdmin',
        'BjyAuthorize',
        'SaasBootstrap',
        'Vpbxui',
    	'Saas',
        'Restful',    		
        'ReverseForm',
        'DOMPDFModule'        
     ),

    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),

        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php'        
        ),
    ),

);
