<?php
return array(
    'console' => array(
    		'router' => array(
    				'routes' => array(
    						'backup' => array(
    								'options' => array(
    										'route'    => 'backup',
    										'defaults' => array(
    												'controller' => 'Maintainer\Controller\RecordingBackup',
    												'action'     => 'index'
    										)
    								)
    						)
    				)
    		)
    ),
    'view_manager' => array(
    		'display_not_found_reason' => true,
    		'display_exceptions'       => true,
        )
);
