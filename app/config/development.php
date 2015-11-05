<?php

/**
 * Override base configs for development environment
 * 
 * APPLICATION_ENV
 */


// app/config/development.php
$development = [
    'application' => [
        'loggingDir' => '/tmp/',
        'baseUri' => '/',
        'basePath' => '/',
        'publicUrl' => 'http://base-api.dev:8080',
        'debugApp' => false,
        'corsOrigin' => 'http://base-api.dev:8080'
    ],
    // user local database for easy example
    'dbname' => APPLICATION_PATH . 'database/sample-database.sqlite',
    //
    'fileStorage' => [
        'basePath' => '/tmp/'
    ]
];

return $development;