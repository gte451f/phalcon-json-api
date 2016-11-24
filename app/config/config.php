<?php
// define if it isn't already in place
// need for CLI scenarios
defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__ . '/../');

// your main application config file
// place values common to all installs here, but it can be over written by environmental specific arrays
$appConfig = [
    // enable security for controllers marked as secure?
    'security' => false,
];

// override config by environment config
$override_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . APPLICATION_ENV . '.php';

// include environment specific values
if (file_exists($override_path)) {
    require_once $override_path;
    $appConfig = array_merge_recursive_replace($appConfig, $environmentConfig);
}

// load security rules if they have been defined
$security_rules_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'security_rules/' . APPLICATION_ENV . '.php';

if (file_exists($security_rules_path)) {
    require_once $security_rules_path;
    $appConfig = array_merge_recursive_replace($appConfig, $security_rules);
}


// the api currently expect an array, not the phalcon config object
return $appConfig;