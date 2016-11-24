<?php
error_reporting(E_ALL);

// Override production configs for development environment
// this development environment is configured for docker usage
$environmentConfig = [
    'application' => [
        // where to store cache related files
        'cacheDir' => '/tmp/',
        // FQDN
        'publicUrl' => 'http://localhost:8080',
        // probably the same FQDN
        'corsOrigin' => 'https://localhost:8080',
        // should the api return additional meta data and enable additional server logging?
        'debugApp' => true,
        // where should system temp files go?
        'tempDir' => '/tmp/',
        // where should app generated logs be stored?
        'loggingDir' => '/tmp/',
        // what is the path after the FQDN?
        'baseUri' => '/v1/',

        // how should property names be formatted in results?
        // possible values are camel, snake, dash and none
        // none means perform no processing on the final output
        'propertyFormatTo' => 'dash',

        // how are your existing database field name formatted?
        // possible values are camel, snake, dash
        // none means perform no processing on the incoming values
        'propertyFormatFrom' => 'snake',

        // would also accept any FOLDER name in Result\Adapters
        'outputFormat' => 'JsonApi'
    ],
    // user local database for easy example
    'dbname' => APPLICATION_PATH . 'database/sample-database.sqlite',

    // used as a system wide prefix to all file storage paths
    'fileStorage' => [
        'basePath' => '/file_storage/'
    ]
];

// Define APPNAME if this is production environment
// - must be defined on each deployed PRODUCTION version
// useful when the production code is deployed in multiple configurations ie. portal or admin
defined('APPLICATION_NAME') || define('APPLICATION_NAME', 'admin');