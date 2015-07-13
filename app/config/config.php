<?php
// define if it isn't already in palce
defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__ . '/../');
defined('APPLICATION_ENV') || define('APPLICATION_ENV', 'staging');

/**
 * load low level helper here so it also works when used in conjunction with phalcon devtools
 */
require_once APPLICATION_PATH . 'helpers/base.php';

// your main aplication config file
// app/config/config.php
$config = [
    'application' => [
        'cacheDir' => '/tmp/cache/',
        'appDir' => APPLICATION_PATH,
        "controllersDir" => APPLICATION_PATH . 'controllers/',
        "modelsDir" => APPLICATION_PATH . 'models/',
        "entitiesDir" => APPLICATION_PATH . 'entities/',
        "responsesDir" => APPLICATION_PATH . 'responses/',
        "exceptionsDir" => APPLICATION_PATH . 'exceptions/',
        "librariesDir" => APPLICATION_PATH . 'libraries/',
        'baseUri' => '/',
        'basePath' => '/',
        'publicUrl' => 'http://localhost:8080/phalcon-json-api/',
        'debugApp' => false,
        'corsOrigin'=> 'http://localhost:4200'
    ]
];

// override production config by enviroment config
$override_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . APPLICATION_ENV . '.php';

// log the correct combination of config values
$config = file_exists($override_path) ? array_merge_recursive_replace($config, require (APPLICATION_ENV . '.php')) : $config;

return new \Phalcon\Config($config);