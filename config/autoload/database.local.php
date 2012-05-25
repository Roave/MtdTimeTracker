<?php

$dbParams = array(
    'database'  => 'changeme',
    'username'  => 'changeme',
    'password'  => 'changeme',
    'hostname'  => 'localhost',
);

return array(
    'service_manager' => array(
        'factories' => array(
            'zfcuser_zend_db_adapter' => function($sm) {
                return $sm->get('Zend\Db\Adapter\Adapter');
            },

            'zfcuseracl_db_adapter' => function($sm) {
                return $sm->get('Zend\Db\Adapter\Adapter');
            },

            'Zend\Db\Adapter\Adapter' => function ($sm) use ($dbParams) {
                return new Zend\Db\Adapter\Adapter(array(
                    'driver'    => 'pdo',
                    'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
                    'database'  => $dbParams['database'],
                    'username'  => $dbParams['username'],
                    'password'  => $dbParams['password'],
                    'hostname'  => $dbParams['hostname'],
                ));
            },
        ),
    ),
);
