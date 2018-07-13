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
            ],
            [
                'type' => 'parameter',
                'value' => 'database',
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
    'fileCache' => [
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
    'modelsMetadata' => [
        'className' => 'Kernel\\Service\\MetaDataService',
        'arguments' => [
            [
                'type' => 'parameter',
                'value' => null,
            ]

        ]
    ],
    'view' => [
        'className' => 'Kernel\\Service\\ViewService',
        'arguments' => [
            [
                'type' => 'parameter',
                'value' => null,
            ]

        ]
    ],
    'router' => [
        'className' => 'Kernel\\Service\\RouterService',
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'config',
            ],
            [
                'type' => 'parameter',
                'value' => true,
            ]

        ]
    ],
    'flash' => [
        'className' => 'Kernel\\Service\\FlashService',
        'arguments' => [
            [
                'type' => 'parameter',
                'value' => null,
            ]

        ]
    ],
    'dispatcher' => [
        'className' => 'Kernel\\Service\\DispatcherService',
    ],
    'utils' => [
        'className' => 'Kernel\\Service\\UtilsService',
    ],
];
















