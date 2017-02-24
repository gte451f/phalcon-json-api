<?php
// define if it isn't already in place
// need for CLI scenarios
defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__ . '/../');

// load low level helper here so it also works when used in conjunction with phalcon cli
require_once APPLICATION_PATH . 'helpers/base.php';

// your main application config file
// place values common to all installs here, but it can be over written by environmental specific arrays
$config = [
    // how should property names be formatted in results?
    // possible values are camel, snake, dash and none
    // none means perform no processing on the final output
    'propertyFormatTo' => 'dash',

    // how are your existing database field name formatted?
    // possible values are camel, snake, dash
    // none means perform no processing on the incoming values
    'propertyFormatFrom' => 'snake',

    // would also accept any FOLDER name in Result\Adapters
    'outputFormat' => 'JsonApi',

    // enable security for controllers marked as secure?
    'security' => false,
];

// override production config by environment config
$override_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . APPLICATION_ENV . '.php';

// log the correct combination of config values
$config = file_exists($override_path) ?
    array_merge_recursive_replace($config, require(APPLICATION_ENV . '.php')) :
    $config;

// the api currently expect an array, not the phalcon config object
return $config;