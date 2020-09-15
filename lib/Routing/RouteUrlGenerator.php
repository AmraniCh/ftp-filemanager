<?php

namespace FTPApp\Routing;

use FTPApp\Routing\Exception\RouteInvalidArgumentException;

class RouteUrlGenerator
{
    /** @var RouteCollection */
    protected $routes;

    /**
     * RouteUrlGenerator constructor.
     *
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Generates a path based on the current request path upon
     * the giving route name and passed parameters.
     *
     * @param string $routeName
     * @param array  $params
     *
     * @return string
     */
    public function generate($routeName, $params = [])
    {
        if (!($route = $this->getRoute($routeName))) {
            throw new RouteInvalidArgumentException("Route [$routeName] not registered.");
        }

        if (!$this->hasMatchType($route->getPath())) {
            return $this->getRoutingPath() . $route->getPath();
        }

        $subject = $route->getPath();
        $replace = '';
        foreach ($params as $param) {
            $replace = preg_replace('/:(\w+)/i', $param, $subject, 1);
            $subject = $replace;
        }

        return $this->getRoutingPath() . $replace;
    }

    /**
     * @param string $name
     *
     * @return Route|false
     */
    protected function getRoute($name)
    {
        /** @var Route $route */
        foreach ($this->routes->getRoutes() as $route) {
            if ($route->getName() === $name) {
                return $route;
            }
        }

        return false;
    }

    /**
     * @param string $routeName
     *
     * @return bool
     */
    protected function hasMatchType($routeName)
    {
        return preg_match('/:(\w+)/i', $routeName) === 1;
    }

    /**
     * Gets the actual routing path.
     *
     * @return string
     */
    protected function getRoutingPath()
    {
        $query = str_replace('/', '\\/', $_SERVER['QUERY_STRING']);
        $uri = preg_replace('/\?/', '&', $_SERVER['REQUEST_URI'], 1);
        $result =  preg_replace('/'.$query.'$|index.php$|&$/', '', $uri);
        return preg_replace('/\/$/', '', $result);
    }
}