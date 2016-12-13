<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::ERROR,
        ],
        'speedTestService'  =>  [
            'timeout'   => 20,
            'testUrl'   =>  'http://speedtest2.verticalbroadband.com/speedtest/random3000x3000.jpg'
        ],
        'authService'  =>  [
            'apiKey'    =>  'yassineX'
        ]
    ],
];
