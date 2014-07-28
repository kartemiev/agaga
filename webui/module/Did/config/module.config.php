<?php
return array(

    'router' => array(
        'routes' => array( 
        		'pickdid' => array(
                'type' => 'Segment',
                
                'options' => array(
                    'route' => '/pickdid[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                    'defaults' => array(
                        'controller' => 'Did\Controller\PickDid',
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
   		'template_map'=>array(
   				'paginator-slideDid'         =>  __DIR__ . '/../view/layout/slidePaginatorDid.phtml',   					
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
        ),
    ),
);

