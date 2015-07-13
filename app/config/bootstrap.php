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
$app->before(function () use($app, $di) {
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
 * The base route returns the list of defined routes for the application.
 * This is not strictly REST compliant, but it helps to base API documentation off of.
 * By calling this, you can quickly see a list of all routes and their methods.
 */
$app->get('/', function () use($app) {
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
$app->after(function () use($app) {
    $method = $app->request->getMethod();
    
    switch ($method) {
        case 'OPTIONS':
            $app->response->setStatusCode('200', 'OK');
            $app->response->send();
            break;
        
        case 'DELETE':
            $app->response->setStatusCode('204', 'No Content');
            $app->response->send();
            return;
            break;
        
        case 'POST':
            $app->response->setStatusCode('201', 'Created');
            break;
        
        default:
            ;
            break;
    }
    
    $requestType = $app->request->get('type');
    // Respond by default as JSON
    if (! $requestType) {
        $requestType = 'json';
    }
    
    switch ($requestType) {
        case 'json':
            // Results returned from the route's controller. All Controllers should return an array
            $records = $app->getReturnedValue();
            
            $response = new \PhalconRest\Responses\JSONResponse();
            // this is default behavior
            $response->useEnvelope(false)
                ->convertSnakeCase(false)
                ->send($records);
            return;
            break;
        
        case 'csv':
            $records = $app->getReturnedValue();
            $response = new \PhalconRest\Responses\CSVResponse();
            $response->useHeaderRow(true)
                ->send($records);
            return;
            break;
        
        case 'html':
            $records = $app->getReturnedValue();
            $response = new \PhalconRest\Responses\HTMLResponse();
            $response->send($records);
            return;
            break;
        
        default:
            throw new \PhalconRest\Util\HTTPException('Could not return results in specified format', 403, array(
                'dev' => 'Could not understand type specified by type paramter in query string.',
                'internalCode' => '3',
                'more' => 'Type may not be implemented. Choose either "csv" or "json"'
            ));
            break;
    }
});

/**
 * The notFound service is the default handler function that runs when no route was matched.
 * We set a 404 here unless there's a suppress error codes.
 */
$app->notFound(function () use($app, $di) {
    $request = $di->get('request');
    $query = $request->getQuery();
    $url = '?';
    $count = 0;
    foreach ($query as $key => $value) {
        if ($count > 0) {
            $url .= "&";
        }
        $url .= "$key=$value";
        $count++;
    }
    
    throw new \PhalconRest\Util\HTTPException('Not Found.', 404, array(
        'dev' => "That route was not found on the server: " . $url,
        'internalCode' => '4',
        'more' => 'Check route for mispellings.'
    ));
});

/**
 * If the application throws an HTTPException, send it on to the client as json.
 * Elsewise, just log it.
 * TODO: Improve this.
 * TODO: Kept here due to dependency on $app
 */
set_exception_handler(function ($exception) use($app) {
    // HTTPException's send method provides the correct response headers and body
    if (is_a($exception, 'PhalconRest\\Util\\HTTPException')) {
        $exception->send();
    }
    
    // HTTPException's send method provides the correct response headers and body
    if (is_a($exception, 'PhalconRest\\Util\\ValidationException')) {
        $exception->send();
    }
    error_log($exception);
    error_log($exception->getTraceAsString());
});