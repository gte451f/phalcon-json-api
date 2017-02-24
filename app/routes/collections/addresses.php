<?php

/**
 * This is an example of a custom route file where you can define different actions on the route
 * you'll see below a set of standard actions that are support on this route
 * if your end point only requires the standard actions, then consider defining it in routes/routeLoader.php instead
 */
return call_user_func(function ()
{
    $routes = new \Phalcon\Mvc\Micro\Collection();

    // VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
    // setHandler MUST be a string in order to support lazy loading
    $routes->setPrefix('/v1/addresses')
        ->setHandler('\PhalconRest\Controllers\AddressController')
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

    return $routes;
});