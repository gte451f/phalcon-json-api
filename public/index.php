<?php
// let apache tell us what environment we are in
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', str_replace('/public', '/app/', __DIR__));

use \PhalconRest\Util\HTTPException;
error_reporting(E_ALL);

try {
    
    /**
     * read in config values
     */
    require_once APPLICATION_PATH . 'config/config.php';
    
    /**
     * bootstrap phalcon autoload including composer
     */
    require_once APPLICATION_PATH . 'config/loader.php';
    
    /**
     * read in services
     */
    require_once APPLICATION_PATH . 'config/services.php';
    
    /**
     * init app object
     */
    require_once APPLICATION_PATH . 'config/bootstrap.php';
    
    /**
     * handle here for unit testing requirement
     */
    $app->handle();
} catch (Phalcon\Exception $e) {
    // now what do i do?
    // echo $e->getMessage();
    // print_r($e->getTrace());
    
    throw new HTTPException("Fatal Exception Caught.", 500, array(
        'dev' => $e->getMessage(),
        'internalCode' => '6846846846161'
    ));
    
    // d($e->getTrace());
} catch (PDOException $e) {    
    // echo $e->getMessage();
    print_r($e->getTrace());    
}