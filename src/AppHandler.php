<?php

namespace FTPApp;

use FTPApp\Controllers\Controller;
use FTPApp\Controllers\Error\ErrorController;
use FTPApp\DIC\DIC;
use FTPApp\Http\HttpRequest;
use FTPApp\Routing\RouteCollection;
use FTPApp\Routing\RouteDispatcher;

class AppHandler
{
    /**
     * @var HttpRequest
     */
    protected $request;

    /**
     * AppHandler constructor.
     *
     * @param HttpRequest $request
     * @param DIC         $container
     */
    public function __construct(HttpRequest $request, DIC $container)
    {
        $this->request = $request;
        Controller::setContainer($container);
    }

    /**
     * Handles the request and returns the appropriate response.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function handle()
    {
        $routesCollection = new RouteCollection(include(dirname(__DIR__) . '/config/routes.php'));
        $dispatcher = new RouteDispatcher($routesCollection, $this->request->getUri(), $this->request->getMethod());

        $dispatcher->notFoundedHandler(function () {
            return (new ErrorController($this->request))->index(404);
        });

        $dispatcher->methodNotAllowedHandler(function ($routeInfo) {
            return (new ErrorController($this->request))->index(405, [
                /**
                 * Sending the 'Allow' header including the allowed methods
                 * for the request as defined in RFC 7231.
                 *
                 * @link https://tools.ietf.org/html/rfc7231#section-6.5.5
                 */
                'Allow' => implode(', ', $routeInfo[0]),
            ]);
        });

        // Dispatches the routes and define the founded handler as a callback
        return $dispatcher->dispatch(function ($routeInfo) {
            $handler = $routeInfo[2];

            // Callback
            if (!is_array($handler)) {
                return call_user_func_array($handler, $routeInfo[3]);
            }

            // Controller
            $class  = $handler[0];
            $method = $handler[1];

            $vars = '';
            if (isset($handler[2])) {
                $vars = implode(',', $handler[2]);
            }

            $controller = new $class($this->request);
            return $controller->$method($vars);
        });
    }
}