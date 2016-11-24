<?php
// let apache tell us what environment we are in
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', str_replace('/public', '/app/', __DIR__));

// Define path to composer & the API itself
defined('COMPOSER_PATH') || define('COMPOSER_PATH', str_replace('/public', '/vendor/', __DIR__));
defined('API_PATH') || define('API_PATH', COMPOSER_PATH . 'gte451f/phalcon-json-api-package/src/');

use \PhalconRest\Exception\HTTPException;
use \PhalconRest\Exception\DatabaseException;

// use output buffer to manage what is actually sent to the client...or clean it out before it's sent
ob_start();

try {
    /**
     * bootstrap Phalcon Auto Loader with composer libraries as well
     * a bit of a hack, but it provides an entry point down to the core API files
     */
    require_once API_PATH . 'bin/loader.php';

    /**
     * read in custom services this particular app requires
     */
    require_once APPLICATION_PATH . 'config/services.php';

    /**
     * handle here for unit testing requirement
     */
    $app->handle();
} catch (Phalcon\Exception $e) {
    // process an uncaught exception as a generic HTTP exception
    throw new HTTPException("Phalcon Exception Caught.", 500, array(
        'dev' => $e->getTrace(),
        'more' => $e->getMessage(),
        'code' => '89798414618968161'
    ));
} catch (PDOException $e) {
    // catch any unexpected database exceptions
    throw new DatabaseException("Fatal Database Exception Caught.", 500, array(
        'dev' => $e->getTrace(),
        'more' => $e->getMessage(),
        'code' => '313519613516184'
    ));
}