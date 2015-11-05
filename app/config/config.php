<?php
// define if it isn't already in palce
// need for CLI scenarios
defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__ . '/../');

/**
 * load low level helper here so it also works when used in conjunction with phalcon devtools
 */
require_once APPLICATION_PATH . 'helpers/base.php';
require_once APPLICATION_PATH . 'helpers/file.php';

// your main aplication config file
// app/config/config.php
$config = [
    'application' => [
        'appDir' => APPLICATION_PATH,
        "controllersDir" => APPLICATION_PATH . '/controllers/',
        "modelsDir" => APPLICATION_PATH . '/models/',
        "entitiesDir" => APPLICATION_PATH . '/entities/',
        "responsesDir" => APPLICATION_PATH . '/responses/',
        "exceptionsDir" => APPLICATION_PATH . '/exceptions/',
        "librariesDir" => APPLICATION_PATH . '/libraries/',
    ],
    'smtp' => [
        'fromName' => 'Smith & Carson',
        'fromEmail' => 'general@smithcarson.com',
        'server' => 'ssl://smtp.googlemail.com',
        'port' => 465,
        'security' => 'tls',
        'username' => 'general@smithcarson.com',
        'password' => '7d8ev8f75d)'
    ],

    'namespaces' => [
        'models' => "PhalconRest\\Models\\",
        'controllers' => "PhalconRest\\Controllers\\",
        'libraries' => "PhalconRest\\Libraries\\",
        'entities' => "PhalconRest\\Entities\\"
    ]
];

// override production config by enviroment config
$override_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . APPLICATION_ENV . '.php';

// log the correct combination of config values
$config = file_exists($override_path) ? array_merge_recursive_replace($config, require (APPLICATION_ENV . '.php')) : $config;

// load security rules if they have been defined
$security_rules_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'security_rules.php';
$config = (file_exists($security_rules_path)) ? array_merge_recursive_replace($config, require ('security_rules.php')) : $config;

return new \Phalcon\Config($config);