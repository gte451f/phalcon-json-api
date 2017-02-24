<?php
use PhalconRest\Exception\DatabaseException;
use PhalconRest\Exception\HttpException;

// let web server tell us what environment we are in
// this will determine, among other things, which config files to load
defined('APPLICATION_ENV') || define('APPLICATION_ENV',
    (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', str_replace('/public', '/app/', __DIR__));

// Define path to composer & the API package itself
defined('COMPOSER_PATH') || define('COMPOSER_PATH', str_replace('/public', '/vendor/', __DIR__));
defined('API_PATH') || define('API_PATH', COMPOSER_PATH . 'gte451f/phalcon-json-api-package/src/');

error_reporting(E_ALL);  // sure let's know about everything now!
ini_set('html_errors', 'off');  // prevent interference with json based error reporting

try {
    /*
     * bootstrap Phalcon Auto Loader with composer libraries as well
     * a bit of a hack, but it provides an entry point down to the core API files
     */
    require_once API_PATH . 'bin/loader.php';

    /*
     * read in custom services this particular app requires
     */
    require_once APPLICATION_PATH . 'config/services.php';

    /*
     * load app specific helpers
     * these are different than the helpers loaded by the API in it's own helper file
     */
    require_once APPLICATION_PATH . 'helpers/base.php';

    /*
     * handle here for unit testing requirement
     */
    $app->handle();
} catch (Phalcon\Exception $e) {
    if ($config['application']['debugApp'] == true) {
        http_response_code(500);
        echo 'Framework exception caught: ' . $e->getMessage(), PHP_EOL;
        echo $e->getTraceAsString(), PHP_EOL;
    } else {
        throw new HTTPException('Framework Exception Caught.', 500, [
            'dev' => $e->getMessage(),
            'code' => '49846461681613616813.3131'
        ]);
    }
} catch (PDOException $e) {
    // seems like this is only run when an unexpected database exception occurs
    if ($config['application']['debugApp'] == true) {
        http_response_code(500);
        echo 'Database exception caught: ' . $e->getMessage(), PHP_EOL;
        echo $e->getTraceAsString(), PHP_EOL;
    } else {
        throw new DatabaseException('Database Exception Caught.', 500, [
            'dev' => $e->getMessage(),
            'code' => '546846131616106860'
        ]);
    }
}