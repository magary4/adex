<?php

define('APP_ROOT', __DIR__ . '/..');

return [
    'settings' => [


        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header



        // Renderer settings
        /*'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],*/



        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],


        // Doctrine
        'doctrine' => [
            // if true, metadata caching is forcefully disabled
            'dev_mode' => true,

            // false to stop caching entity mapping. Only for debugging mapping.
            'entity_dev_mode' => true,

            // path where the compiled metadata info will be cached
            // make sure the path exists and it is writable
            'cache_dir' => APP_ROOT . '/var/cache/doctrine',
            'proxy_dir' => APP_ROOT . '/var/cache/doctrine',

            // you should add any other path containing annotated entity classes
            //'metadata_dirs' => [APP_ROOT . '/src/Domain'],

            'xml_metadata_dirs' => [APP_ROOT . '/src/Adapter/Doctrine/mappings'],
            'php_metadata_dirs' => [APP_ROOT . '/configs/doctrine/mappings'],

            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => 'api_mysql',
                'port' => 3306,
                'dbname' => 'adex_api',
                'user' => 'adex_api',
                'password' => 'adex_api',
                'charset' => 'utf8'
            ]
        ]
    ],
];
