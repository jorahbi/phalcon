<?php
//注册服务配置

return [
    "redis" => [
        "className" => "Kernel\\Service\\RedisService",
        "arguments" => [
            [
                "type" => "service",
                "name" => "config",
            ]

        ]
    ],
    'db' => [
        'className' => 'Kernel\\Service\\MysqlService',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'config',
            ]

        ]
    ],
    'session' => [
        'className' => 'Kernel\\Service\\SessionService',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'config',
            ]

        ]
    ],
    'cookies' => [
        'className' => 'Kernel\\Service\\CookieService',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'config',
            ]

        ]
    ],
    'file' => [
        'className' => 'Kernel\\Service\\FileService',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'config',
            ]

        ]
    ],
    'modelsCache' => [
        'className' => 'Kernel\\Service\\ModelsCacheService',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'config',
            ]

        ]
    ],
    'crypt' => [
        'className' => 'Kernel\\Service\\CryptService',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'config',
            ]

        ]
    ],
    'security' => [
        'className' => 'Kernel\\Service\\SecurityService',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'config',
            ]

        ]
    ],
];
















