<?php

return [
    'default' => [
        'module' => 'frontend',
        'namespace' => 'Frontend\\Controllers',
        'controller' => 'index',
        'action' => 'index',
    ],
    'notFound' => [
        'module' => 'frontend',
        'namespace' => 'Frontend\\Controllers',
        'controller' => 'index',
        'action' => 'route404',
    ],
    'group' => [
        '' => [
            'module' => 'frontend',
            'namespace' => 'Frontend\\Controllers',
        ],
        '/admin' => [
            'module' => 'admin',
            'namespace' => 'Admin\\Controllers',
        ],
    ],
    'other' => [
        [
            'url' => '',
            'module' => '',
            'controller' => '',
            'action' => '',
            'group' => '',
        ],
    ],
];
