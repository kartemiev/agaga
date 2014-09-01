<?php
return array(
    'modules' => array(
    	'ZfcBase',
        'ZfcUser',
		'ZfcAdmin',
		'ZfcUserAdmin',
        'BjyAuthorize',
        'Vpbxui',
    	'Saas',
        'Restful',    		
        'ReverseForm'
    ),

    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),

        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),

);
