<?php
return array(
    'console' => array(
    		'router' => array(
    				'routes' => array(
    						'agi' => array(
    								'options' => array(
    										'route'    => 'processrecorded',
    										'defaults' => array(
    												'controller' => 'AgiHelper\Controller\ProcessRecorded',
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
