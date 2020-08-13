<?php

namespace FTPApp;

use FTPApp\Controllers\Controller;
use FTPApp\Controllers\Error\ErrorController;
use FTPApp\DIC\DIC;
use FTPApp\Http\HttpRequest;
use FTPApp\Routing\Exception\RouteLogicException;
use FTPApp\Routing\RouteDispatcher;

class AppHandler
{
    /**
     * @var HttpRequest
     */
    protected $request;

    /** @var RouteDispatcher */
    protected $dispatcher;

    /** @var DIC */
    protected $container;

    /**
     * AppHandler constructor.
     *
     * @param HttpRequest     $request
     * @param RouteDispatcher $dispatcher
     * @param DIC             $container
     */
    public function __construct(HttpRequest $request, RouteDispatcher $dispatcher, DIC $container)
    {
        $this->request    = $request;
        $this->dispatcher = $dispatcher;
        $this->container  = $container;
    }

    /**
     * Initializes the application.
     *
     * @return void
     */
    public function init()
    {
        // Set the base controller container
        Controller::setContainer($this->container);
    }

    /**
     * Handles the request and returns the appropriate response.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->dispatcher->notFoundedHandler(function () {
            return (new ErrorController($this->request))->index(404);
        });

        $this->dispatcher->methodNotAllowedHandler(function ($routeInfo) {
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

        // Define the founded handler as a dispatcher callback
        return $this->dispatcher->dispatch(function ($routeInfo) {
            $handler = $routeInfo[2];

            // Callback
            if (!is_array($handler)) {
                return call_user_func_array($handler, $routeInfo[3]);
            }

            // Controller
            $class  = $handler[0];
            $method = $handler[1];

            $controller = new $class($this->request);
            if (!method_exists($controller, $method)) {
                throw new RouteLogicException("Invoking a non existing controller method [$method].");
            }

            return call_user_func_array(
                [$controller, $method],
                isset($handler[2]) ? $handler[2] : []
            );
        });
    }
}