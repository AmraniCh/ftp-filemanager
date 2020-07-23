<?php

namespace FTPApp\Routing;

class RouteCollection
{
    protected $routes;

    /**
     * RouteCollection constructor.
     *
     * @param array $routes
     */
    public function __construct($routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}