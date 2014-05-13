<?php
 return array(
    'console' => array(
        'router' => array(
            'routes' => array(
              'my-first-route' => array(
     'options' => array(
        'route'    => 'foo bar',
        'defaults' => array(
            'controller' => 'Fax\Controller\ParseFaxEmail',
            'action'     => 'Index'
        )
    )
 )
            )
        )
    ));
    