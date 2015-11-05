<?php
use Phalcon\Mvc\Micro\Collection;

/**
 * Our application is a Micro application, so we must explicitly define all the routes.
 * For APIs, this is ideal. This is as opposed to the more robust MVC Application
 *
 * @var $app
 */
$app = new Phalcon\Mvc\Micro();
$app->setDI($di);

/**
 * Before every request:
 * Returning true in this function resumes normal routing.
 * Returning false stops any route from executing.
 */

/**
 * set standard CORS headers before routing just incase no valid route is found
 */
$app->before(function () use($app, $di)
{
    $config = $di->get('config');
    $app->response->setHeader('Access-Control-Allow-Origin', $config['application']['corsOrigin']);
    return true;
});

/**
 * Mount all of the collections, which makes the routes active.
 */
foreach ($di->get('collections') as $collection) {
    $app->mount($collection);
}

/**
 * The base route return the list of defined routes for the application.
 * This is not strictly REST compliant, but it helps to base API documentation off of.
 * By calling this, you can quickly see a list of all routes and their methods.
 */
$app->get('/', function () use($app)
{
    $routes = $app->getRouter()
        ->getRoutes();
    $routeDefinitions = array(
        'GET' => array(),
        'POST' => array(),
        'PUT' => array(),
        'PATCH' => array(),
        'DELETE' => array(),
        'HEAD' => array(),
        'OPTIONS' => array()
    );
    foreach ($routes as $route) {
        $method = $route->getHttpMethods();
        $routeDefinitions[$method][] = $route->getPattern();
    }
    return $routeDefinitions;
});

/**
 * After a route is run, usually when its Controller returns a final value,
 * the application runs the following function which actually sends the response to the client.
 *
 * The default behavior is to send the Controller's returned value to the client as JSON.
 * However, by parsing the request querystring's 'type' paramter, it is easy to install
 * different response type handlers.
 */
$app->after(function () use($app)
{
    $method = $app->request->getMethod();
    $output = new \PhalconRest\API\Output();
    
    switch ($method) {
        case 'OPTIONS':
            $app->response->setStatusCode('200', 'OK');
            $app->response->send();
            return;
            break;
        
        case 'DELETE':
            $app->response->setStatusCode('204', 'No Content');
            $app->response->send();
            return;
            break;
        
        case 'POST':
            $output->setStatusCode('201', 'Created');
            break;
    }
    
    // Results returned from the route's controller. All Controllers should return an array
    $records = $app->getReturnedValue();
    
    // this is default behavior
    $output->convertSnakeCase(false)
        ->send($records);
    return;
});

/**
 * The notFound service is the default handler function that runs when no route was matched.
 * We set a 404 here unless there's a suppress error codes.
 */
$app->notFound(function () use($app, $di)
{
    $request = $di->get('request');
    $query = $request->getQuery();
    $url = '?';
    $count = 0;
    foreach ($query as $key => $value) {
        if ($count > 0) {
            $url .= "&";
        }
        $url .= "$key=$value";
        $count ++;
    }
    
    throw new \PhalconRest\Util\HTTPException('Not Found.', 404, array(
        'dev' => "That route was not found on the server: " . $url,
        'code' => '4',
        'more' => 'Check route for mispellings.'
    ));
});

/**
 * If the application throws an HTTPException, send it on to the client as json.
 * Elsewise, just log it.
 * TODO: Improve this.
 * TODO: Kept here due to dependency on $app
 */
set_exception_handler(function ($exception) use($app, $config)
{
    // $config = $di->get('config');
    
    // HTTPException's send method provides the correct response headers and body
    if (is_a($exception, 'PhalconRest\\Util\\HTTPException')) {
        $exception->send();
        error_log($exception);
        // end early to make sure nothing else gets in the way of delivering response
        return;
    }
    
    // HTTPException's send method provides the correct response headers and body
    if (is_a($exception, 'PhalconRest\\Util\\ValidationException')) {
        $exception->send();
        error_log($exception);
        // end early to make sure nothing else gets in the way of delivering response
        return;
    }
    
    // seems like this is only run when an unexpected exception occurs
    if ($config['application']['debugApp'] == true) {
        Kint::dump($exception);
    }
});