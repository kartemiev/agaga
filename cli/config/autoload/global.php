<?php
return array(
   'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'pgsql:dbname=agaga'
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);
