<?php

/**
 * Standard routes for resource
 * Refer to reoutes/collections/example.php for further details
 */
return call_user_func(function ()
{
    $routes = new \Phalcon\Mvc\Micro\Collection();
    
    // VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
    // setHandler MUST be a string in order to support lazy loading
    $routes->setPrefix('/v1/users')
        ->setHandler('\PhalconRest\Controllers\UserController')
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