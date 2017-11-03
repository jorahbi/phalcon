<?php

 return [
	'application' => [
    'controllersDir' => __DIR__ . '/../controllers/',
    'modelsDir'      => __DIR__ . '/../models/',
    'viewsDir'       => __DIR__ . '/../views/default/',
    ],
    'security' => [
    	'loginController' => 'index',
        'loginAction' => 'login'
    ],
    'cache' => [
    	'cacheDir' => 'admin/'
    ]
];


