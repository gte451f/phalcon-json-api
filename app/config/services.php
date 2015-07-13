<?php
// FacntoryDefault loads all services by default....
use Phalcon\DI\FactoryDefault as DefaultDI;
use Phalcon\Loader;

// used for logging sql commands
use Phalcon\Logger;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;
use PhalconRest\Libraries\MessageBag as MessageBag;
use PhalconRest\Libraries\Registry as Registry;
use Phalcon\Security as Security;

// PhalconRest libraries
use PhalconRest\API\Request as Request;
use PhalconRest\API\Util\Inflector;

// for keeping time
use PHPBenchTime\Timer;

$T = new \PHPBenchTime\Timer();
$T->start();

/**
 * The DI is our direct injector.
 * It will store pointers to all of our services
 * and we will insert it into all of our controllers.
 *
 * @var DefaultDI
 */
$di = new DefaultDI();

$di->setShared('request', function () {
    $request = new PhalconRest\API\Request();
    // we expect inputs to be camel, so we convert to snake for server side
    $request->defaultCaseFormat = 'snake';
    return $request;
});

/**
 * $di's setShared method provides a singleton instance.
 * If the second parameter is a function, then the service is lazy-loaded
 * on its first instantiation.
 */
$di->setShared('config', function () use($config) {
    return $config;
});

/**
 * load an authenticator w/ ldap adapter
 */
$di->setShared('ldapAuth', function () use($config) {
    $adapter = new \PhalconRest\Libraries\Authentication\LDAP($config['ldap']);
    $profile = new \PhalconRest\Libraries\Authentication\UserProfile();
    $auth = new \PhalconRest\Authentication\Authenticator($adapter, $profile);
    return $auth;
});

/**
 * load an authenticator w/ local adapter
 * called "auth" since the API expects a service of this name for subsequent token checks
 */
$di->setShared('auth', function () use($config) {
    $adapter = new \PhalconRest\Libraries\Authentication\Local();
    $profile = new \PhalconRest\Libraries\Authentication\UserProfile();
    $auth = new \PhalconRest\Authentication\Authenticator($adapter, $profile);
    return $auth;
});

$di->setShared('securityService', function () use($config) {
    return new \PhalconRest\Libraries\Security\SecurityService();
});

// stopwatch service to track
$di->setShared('stopwatch', function () use($T) {
    // start the stopwatch
    return $T;
});

// hold messages that should be returned to the client
$di->setShared('messageBag', function () {
    return new \PhalconRest\Libraries\MessageBag\MessageBag();
});

/**
 * Return array of the Collections, which define a group of routes, from
 * routes/collections.
 * These will be mounted into the app itself later.
 */
$di->set('collections', function () use($config) {
    $collections = include ('../app/routes/routeLoader.php');
    return $collections;
});

$di->set('modelsCache', function () {
    
    // Cache data for one day by default
    $frontCache = new \Phalcon\Cache\Frontend\Data(array(
        'lifetime' => 3600
    ));
    
    // File cache settings
    $cache = new \Phalcon\Cache\Backend\File($frontCache, array(
        'cacheDir' => '/tmp/'
    ));
    
    return $cache;
});

// used in model
$di->setShared('modelsManager', function () {
    return new \Phalcon\Mvc\Model\Manager();
});

$di->set('modelsMetadata', function () {
    $metaData = new \Phalcon\Mvc\Model\Metadata\Files(array(
        'metaDataDir' => '/tmp/'
    ));
    return $metaData;
});

// used in model
$di->setShared('memory', function () {
    return new \Phalcon\Mvc\Model\MetaData\Memory();
});

// hold messages that should be returned to the client
$di->setShared('registry', function () {
    return new \Phalcon\Registry();
});

$di->setShared('inflector', function () {
    return new Inflector();
});

/**
 * Database setup.
 */
$di->set('db', function () use($config, $di) {
    // config the event and log services
    $eventsManager = new EventsManager();
    $fileName = date("d_m_y");
    $logger = new FileLogger("/tmp/$fileName.log");
    // $registry = new \Phalcon\Registry();
    $registry = $di->get('registry');
    $registry->dbCount = 0;
    
    // Listen all the database events
    $eventsManager->attach('db', function ($event, $connection) use($logger, $registry) {
        if ($event->getType() == 'beforeQuery') {
            $count = $registry->dbCount;
            $count ++;
            $registry->dbCount = $count;
            
            // $logger->log($connection->getSQLStatement(), Logger::INFO);
        }
    });
    
    // $connection = new Connection($config['database']);
    $connection = new Phalcon\Db\Adapter\Pdo\Sqlite($config);
    
    // Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);
    
    return $connection;
});

/**
 * If our request contains a body, it has to be valid JSON.
 * This parses the body into a standard Object and makes that available from the DI.
 * If this service is called from a function, and the request body is not valid JSON or is empty,
 * the program will throw an Exception.
 */
$di->setShared('requestBody', function () {
    $in = file_get_contents('php://input');
    $in = json_decode($in, FALSE);
    
    // JSON body could not be parsed, throw exception
    if ($in === null) {
        throw new HTTPException('There was a problem understanding the data sent to the server by the application.', 409, array(
            'dev' => 'The JSON body sent to the server was unable to be parsed.',
            'internalCode' => '358203478590723',
            'more' => ''
        ));
    }
    
    return $in;
});