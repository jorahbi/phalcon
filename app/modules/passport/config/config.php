<?php

return [
    'application' => [
        'controllersDir' => __DIR__ . '/../controllers/',
        'modelsDir'      => __DIR__ . '/../models/',
        'viewsDir'       => __DIR__ . '/../views/default/',
    ],
    'sso' => [
    	'request' => [
    		'http://ebizsoft.com/index/index'
    	],
    	'expire' => 86400, //一天
    	'token' => 'token',
    ]
];

/*
header("Access-Control-Allow-Origin: http://passport.com");
session_start();
if(isset($_GET['token']))
	setcookie('token', $_GET['token'], time() + 24 * 60 * 60);
echo  'returnjs({"code":"aa", "ccc": "ddd"})';  
*/