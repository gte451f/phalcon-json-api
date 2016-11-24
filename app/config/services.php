<?php
/**
 * load custom services your particular API requires here
 * careful not to duplicate services already loaded by the core api
 */

// used for logging sql commands
use Phalcon\Logger;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as DbProfiler;
use Phalcon\Logger\Adapter\File as FileLogger;

// hold messages that should be returned to the client
$di->setShared('messageBag', function () {
    return new \PhalconRest\Libraries\MessageBag\MessageBag();
});

// hold messages that should be returned to the client
$di->setShared('registry', function () {
    return new \Phalcon\Registry();
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