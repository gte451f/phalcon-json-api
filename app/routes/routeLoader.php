<?php
// keep a simple list of endpoints which use the standard or generic set of routes
// no route file needed, just enter the endpoint and the controller name
$genericRoutes = [
    'address' => 'AddressController',
    'customers' => 'CustomerController',
    'users' => 'UserController'
];

/**
 * routeLoader loads a set of Phalcon Mvc\Micro\Collections from
 * the collections directory.
 *
 * php files in the collections directory must return Collection objects only.
 */
return call_user_func(function () use ($genericRoutes) {
    $collections = [];
    $collectionFiles = scandir(dirname(__FILE__) . '/collections');

    foreach ($collectionFiles as $collectionFile) {
        $pathinfo = pathinfo($collectionFile);
        // Only include php files
        if ($pathinfo['extension'] === 'php' and $pathinfo['basename'] !== 'generic_route.php') {
            // The collection files return their collection objects, so mount
            // them directly into the router.
            $collections[] = include(dirname(__FILE__) . '/collections/' . $collectionFile);
        }
    }

    // process generic routes here
    foreach ($genericRoutes as $endPoint => $controllerName) {

        // define the generic routes here
        $routes = new \Phalcon\Mvc\Micro\Collection();
        $routes->setPrefix('/v1/' . $endPoint)
            ->setHandler('\\PhalconRest\\Controllers\\' . $controllerName)
            ->setLazy(true);

        $routes->options('/', 'optionsBase');
        $routes->options('/{id}', 'optionsOne');
        $routes->get('/', 'get');
        $routes->head('/', 'get');
        $routes->post('/', 'post');
        $routes->get('/{id:[0-9]+}', 'getOne');
        $routes->head('/{id:[0-9]+}', 'getOne');
        $routes->delete('/{id:[0-9]+}', 'delete');
        $routes->put('/{id:[0-9]+}', 'put');
        $routes->patch('/{id:[0-9]+}', 'patch');
        $collections[] = $routes;
    }

    return $collections;
});

