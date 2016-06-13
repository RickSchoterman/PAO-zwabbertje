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
        _DEFAULT => array(
            'route' => '',
            'executable' => array(
                'controller' => 'Index',
                'action' => 'Index',
            ),
            'options' => array(
                'layout' => 'layout/layout',
            ),
        ),
        'employees' => array(
            'route' => 'employees',
            'executable' => array(
                'controller' => 'Index',
                'action' => 'employee',
            ),
            'options' => array(
                'layout' => 'layout/layout',
            ),
        ),
        'schedule'=> array(
            'route' => 'schedule',
            'executable' => array(
                'controller' => 'Index',
                'action' => 'schedule',
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
                'layout' => 'layout/loginLayout',
            ),
            'child-routes' => array(
                'login' => array(
                    'route' => 'auth',
                    'executable' => array(
                        'controller' => 'login',
                        'action' => 'login',
                    ),
                    'options' => array(
                        'layout' => 'layout/loginLayout',
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
        _ERROR => array(
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
        'roles' => array('guest', 'user', 'admin'),
        'guards' => array(
            'controller' => array(
                'guest' => array('login'),
                'user' => array('login', ''),
            ),
        ),
    ),
    'Messenger',
);

?>