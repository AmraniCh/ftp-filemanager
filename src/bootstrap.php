<?php

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use FTPApp\Routing\Route;
use FTPApp\Routing\RouteCollection;
use FTPApp\Routing\RouteDispatcher;
use FTPApp\Http\HttpRedirect;
use FTPApp\Http\HttpRequest;
use FTPApp\Controllers\ErrorController;

require __DIR__ . '/../vendor/autoload.php';

define('ENV', 'DEVELOPMENT');
define('ERROR_LOG_FILE', __DIR__.'/../php-errors.log');

if (defined('ENV')) {
    // Reporting all types of errors
    error_reporting(E_ALL);

    // Enable error logging
    ini_set('log_errors', TRUE);

    // Create an instance of whoops object
    $whoops = new Run;

    switch (ENV) {
        case 'DEVELOPMENT':
            // Enable display errors
            ini_set('display_errors', TRUE);
            // Enable php errors concerning configuration, extensions ...
            ini_set('display_startup_errors', TRUE);
            // Reporting all types of errors
            error_reporting(E_ALL);

            // Using whoops PrettyPageHandler to show errors in the development mode
            $whoops->pushHandler(new PrettyPageHandler);
            break;

        case 'PRODUCTION':
            // Pushing a callback handler to the whoops handlers stack
            $whoops->pushHandler(function (Exception $e) {
                // Build a message string
                $message = sprintf(
                    "[%s] [%s] [%s] [Line : %s]\n",
                    date('Y:m:d h:m:s'),
                    $e->getFile(),
                    $e->getMessage(),
                    $e->getLine()
                );

                // Logging the error info to the predefined logs file
                error_log($message, 3, ERROR_LOG_FILE);

                // Redirect to a custom error page
                $response = new HttpRedirect(
                    'http://' . $_SERVER['HTTP_HOST'] . '/ftp-filemanager/public/error.php', 301
                );
                $response->clearReadyHeaders();
                $response->redirect();
            });
            break;

        default:
            exit('Application environment is not set correctly.');
    }

    // Register this whoops instance as the error & exception handler
    $whoops->register();
}

$request = new HttpRequest;

$routes = new RouteCollection([

    Route::get('/posts/:any-:i', function ($slug, $id) {
        echo "Article Slug : " . $slug;
        echo "<br>";
        echo "Article id : " . $id;
    }),

]);

$dispatcher = new RouteDispatcher($routes, $request->getUri(), $request->getMethod());

$badRouteHandlers = [
    'notFoundedHandler',
    'methodNotAllowedHandler'
];

foreach ($badRouteHandlers as $handler) {
    $method = $handler;
    $dispatcher->$method(function () {
        (new ErrorController())->index();
    });
}

// Dispatches and handles
$dispatcher->dispatch(function ($routeInfo) {
    $handler = $routeInfo[2];

    // Callback
    if (!is_array($handler)){
        call_user_func_array($handler, $routeInfo[3]);
    }

    // Controller
    if (is_array($handler)) {
        $class  = $handler[0];
        $method = $handler[1];

        $controller = new $class;
        $controller->$method();
    }
});
