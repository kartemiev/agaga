<?php
return array(
    'modules' => array(
     	'ZfcBase',
        'ZfcUser',
		'ZfcAdmin',
		'ZfcUserAdmin',
        'BjyAuthorize',
        'Vpbxui',
        'Restful',    		
        'ReverseForm',
        'DOMPDFModule',   
         
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
