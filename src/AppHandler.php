<?php

namespace FTPApp;

use FTPApp\Http\HttpRequest;
use FTPApp\Http\HttpResponse;
use FTPApp\Routing\Route;
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
        $routes = new RouteCollection([

            Route::get('/', function () {
                return new HttpResponse("Homepage!");
            }),

            Route::get('/posts/:any-:i', function ($slug, $id) {
                return new HttpResponse("Article $slug and id $id");
            }),

        ]);

        $dispatcher = new RouteDispatcher($routes, $this->request->getUri(), $this->request->getMethod());

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