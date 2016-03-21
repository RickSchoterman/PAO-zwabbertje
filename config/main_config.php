<?php

return array(
    'vendor' => array(
        'Mvc' => array(
            'default' => array(
                'controller' => 'index',
                'action' => 'index',
            ),
        ),
        'Router' => array(
            'home' => array(
                'route' => '',
                'executable' => array(
                    'controller' => 'index',
                    'action' => 'index',
                ),
                'options' => array(
                    'layout' => 'layout/layout',
                ),
            ),
            '404' => array(
                'route' => 'notFound',
                'executable' => array(
                    'controller' => 'index',
                    'action' => 'notFound',
                ),
                'options' => array(
                    'layout' => 'layout/layout',
                ),
            ),
        ),
        /*'Database' => array(
            'connection' => array(
                'server' => 'localhost',
                'username' => 'root',
                'password' => '',
                'database' => 'site_project',
            ),
        ),*/
    ),
    'services' => array(
        'MessageService' => array(

        ),
    ),
);

?>