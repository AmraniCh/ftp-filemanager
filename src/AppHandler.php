<?php

namespace FTPApp;

use FTPApp\Http\HttpRequest;
use FTPApp\Routing\RouteCollection;
use FTPApp\Routing\RouteDispatcher;
use FTPApp\Controllers\ErrorController;

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
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
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
        $routesCollection = new RouteCollection(include('routes.php'));

        $dispatcher = new RouteDispatcher($routesCollection, $this->request->getUri(), $this->request->getMethod());

        $badRouteHandlers = [
            'notFoundedHandler',
            'methodNotAllowedHandler'
        ];

        foreach ($badRouteHandlers as $handler) {
            $method = $handler;
            $dispatcher->$method(function () {
                return (new ErrorController())->index();
            });
        }

        // Dispatches and handles
        return $dispatcher->dispatch(function ($routeInfo) {
            $handler = $routeInfo[2];

            // Callback
            if (!is_array($handler)){
                return call_user_func_array($handler, $routeInfo[3]);
            }

            // Controller
            $class  = $handler[0];
            $method = $handler[1];

            $controller = new $class;
            return $controller->$method();
        });
    }
}