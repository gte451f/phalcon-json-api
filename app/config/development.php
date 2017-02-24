<?php
error_reporting(E_ALL);

/* Override production configs for a development environment
 * this particular development environment is configured for docker usage (see included docker-compose)
 * create any number of configs with specific values based on the environment in which you are hosting the application
 * for example, use a different config for a staging server or production server
 * set the applications environment value in public/index.php to drive which config files to load
 */
return [
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
        'baseUri' => '/v1/'
    ],
    // user local database for easy example
    'dbname' => APPLICATION_PATH . 'database/sample-database.sqlite',

    // used as a system wide prefix to all file storage paths
    'fileStorage' => [
        'basePath' => '/file_storage/'
    ]
];