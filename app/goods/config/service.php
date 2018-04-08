<?php
//注册服务配置

return [
    "someComponent",
    [
        "className" => "SomeApp\\SomeComponent",
        "calls"     => [
            [
                "method"    => "setResponse",
                "arguments" => [
                    [
                        "type" => "service",
                        "name" => "response",
                    ]
                ]
            ],
            [
                "method"    => "setFlag",
                "arguments" => [
                    [
                        "type"  => "parameter",
                        "value" => true,
                    ]
                ]
            ]
        ]
    ]
];