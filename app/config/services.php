<?php
/**
 * load custom services your particular API requires here
 * careful not to duplicate services already loaded by the core api
 */

use Phalcon\Di;

// used for logging sql commands
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as DbProfiler;
use Phalcon\Logger\Adapter\File as FileLogger;

/**
 * The DI is our direct injector.
 * It will store pointers to all of our services
 * and we will insert it into all of our controllers.
 *
 * @var \Phalcon\DiInterface
 */
$di = Di::getDefault();

// hold messages that should be returned to the client
$di->setShared('messageBag', function () {
    return new \PhalconRest\Libraries\MessageBag\MessageBag();
});

// hold messages that should be returned to the client
$di->setShared('registry', function () {
    return new \Phalcon\Registry();
});

// load a security service applied to select controllers
$di->setShared('securityService', function () use ($config) {
    return new \PhalconRest\Libraries\Security\SecurityService();
});

/**
 * load an authenticator w/ local adapter
 * called "auth" since the API expects a service of this name for subsequent token checks
 */
$di->setShared('auth', function ($type = 'Employee') use ($config) {
    $adapter = new \PhalconRest\Libraries\Authentication\Local();
    $profile = new \PhalconRest\Libraries\Authentication\UserProfile();
    $auth = new \PhalconRest\Authentication\Authenticator($adapter, $profile);
    $auth->userNameFieldName = 'email';
    return $auth;
});



/**
 * Database setup.
 */
$di->set('db', function () use ($config, $di) {
    // config the event and log services
    $eventsManager = new EventsManager();
    $fileName = date("d_m_y");
    $logger = new FileLogger("/tmp/$fileName.log");
    // $registry = new \Phalcon\Registry();
    $registry = $di->get('registry');
    $registry->dbCount = 0;

    // Listen all the database events
    $eventsManager->attach('db', function ($event, $connection) use ($logger, $registry) {
        if ($event->getType() == 'beforeQuery') {
            $count = $registry->dbCount;
            $count++;
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