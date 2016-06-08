<?php

return array(

    //BuildUp
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
        'account' => array(
            'route' => 'account',
            'executable' => array(
                'controller' => 'login',
                'action' => 'index',
            ),
            'options' => array(
                'layout' => 'layout/login',
            ),
            'child-routes' => array(
                'login' => array(
                    'route' => 'auth',
                    'executable' => array(
                        'controller' => 'login',
                        'action' => 'login',
                    ),
                    'options' => array(
                        'layout' => 'layout/login',
                    ),
                ),
                'logout' => array(
                    'route' => 'logout',
                    'executable' => array(
                        'controller' => 'login',
                        'action' => 'logout',
                    ),
                    'options' => array(
                        'layout' => 'layout/index',
                    ),
                ),
            ),
        ),
        'logout' => array(
            'route' => 'logout',
            'executable' => array(
                'controller' => 'login',
                'action' => 'logout',
            ),
            'options' => array(
                'layout' => 'layout/index',
            ),
        ),
        '404' => array(
            'route' => 'notFound',
            'route_type' => '404',
            'executable' => array(
                'controller' => 'index',
                'action' => 'notFound',
            ),
            'options' => array(
                'layout' => 'layout/layout',
            ),
        ),
        'module' => array(
            'route' => 'reservation',
            'executable' => array(
                'module' => 'reservation',
                'action' => 'read'
            ),
            'options' => array(
                'layout' => 'layout/layout',
            ),
            'child-routes' => array(
                'create' => array(
                    'route' => 'create',
                    'executable' => array(
                        'module' => 'reservation',
                        'action' => 'create'
                    ),
                    'options' => array(
                        'layout' => 'layout/layout',
                    ),
                ),
                'read' => array(
                    'route' => 'read',
                    'executable' => array(
                        'module' => 'reservation',
                        'action' => 'read'
                    ),
                    'options' => array(
                        'layout' => 'layout/layout',
                    ),
                ),
            ),
        ),
    ),

    //Settings
    'Session' => array(
        'timeout' => 100000000,
    ),
    'Database' => array(
        'connection' => array(
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'zwabbertje',
        ),
    ),

    //Extern
    'User' => array(
        'table' => 'user',
    ),
    'Messenger',
);

?>