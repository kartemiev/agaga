<?php
return array(
    'router' => array(
        'routes' => array( 
        		'wizard' => array(
        				'type' => 'Segment',
        		
        				'options' => array(
        						'route' => '/api/wizard[/:action]',
        						'constraints' => array(
        								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        						),
        						'defaults' => array(
        								'controller' => 'Saas\Controller\VpbxWizard',
        								'action' => 'index',
        						),
        				),
        				'may_terminate'=>true
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
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
   		'template_map' => array(
   				),
    ),
    'view_helpers' => array(
        'invokables' => array(
         )
    ),
);
