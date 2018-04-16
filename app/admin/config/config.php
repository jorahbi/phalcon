<?php

 return [
	'application' => [
    'controllersDir' => realpath(__DIR__ . '/../controllers/'),
    'modelsDir'      => realpath(__DIR__ . '/../models/'),
    'viewsDir'       => realpath(__DIR__ . '/../views/default/'),
    ],
    'security' => [
    	'loginController' => 'index',
        'loginAction' => 'login'
    ],
    'cache' => [
    	'cacheDir' => 'admin/'
    ]
];


