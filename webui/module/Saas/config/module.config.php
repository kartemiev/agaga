<?php
return array(

    'router' => array(
        'routes' => array( 
        		'wizard' => array(
        				'type' => 'Segment',
        		
        				'options' => array(
        						'route' => '/wizard[/:action]',
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
        		'pickdid' => array(
                'type' => 'Segment',
                
                'options' => array(
                    'route' => '/pickdid[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                    'defaults' => array(
                        'controller' => 'Saas\Controller\PickDid',
                        'action' => 'index',
                    ),
                ),
                'may_terminate'=>true
            ),
        		'createinternal' => array(
        				'type' => 'Segment',
        		
        				'options' => array(
        						'route' => '/createinternal[/:action]',
        						'constraints' => array(
        								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        						),
        						'defaults' => array(
        								'controller' => 'Saas\Controller\CreateInternal',
        								'action' => 'index',
        						),
        				),
        				'may_terminate'=>true
        		),
        		'internalapi' => array(
        				'type'    => 'segment',
        				'options' => array(
        						'route'    => '/internalapi[/:id]',
        						'constraints' => array(
        								'id' => '[0-9]*',
        						),
        						'defaults' => array(
        								'controller' => 'Saas\Controller\InternalApi',
        						),
        		
        				),
        					
        				'may_terminate' => true,
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
   				'vpbx-wizard.phtml'         =>  __DIR__ . '/../view/layout/wizardPartial.phtml',
   				'file-upload.phtml'         =>  __DIR__ . '/../view/layout/fileUploadPartial.phtml',   					
   				),
    ),
    'view_helpers' => array(
        'invokables' => array(
        		'ExtensionTypeDebrief'=>'Saas\View\Helper\ExtensionTypeDebrief',
        		'DidNumberFormat'=>'Saas\View\Helper\DidNumberFormat'
         )
    ),
);