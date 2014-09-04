<?php
return array(
    'router' => array(
        'routes' => array(
						'api' => array(
								'type'    => 'literal',
								'options' => array(
										'route'    => '/api',									 
								),
								'may_terminate' => false,
								'child_routes' => array(								    		    								    
										'freedid' => array(
												'type'    => 'segment',
												'options' => array(
														'route'    => '/did/free[/:id]',
														'constraints' => array(
																'id' => '[0-9]*',
														),
														'defaults' => array(
																'controller' => 'Restful\Controller\WizardFreeDid',
														),
												),
												'may_terminate' => true,
										),		 
								    'vpbxenv' => array(
								        'type'    => 'segment',
								        'options' => array(
								            'route'    => '/vpbxenv[/:id]',
								            'constraints' => array(
								                'id' => '[0-9]*',
								            ),
								            'defaults' => array(
								                'controller' => 'Restful\Controller\VpbxEnv',
								            ),
								        ),
								        'may_terminate' => true,
								    ),
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
