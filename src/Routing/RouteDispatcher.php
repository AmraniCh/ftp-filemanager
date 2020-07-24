<?php

namespace FTPApp\Routing;

use FTPApp\Routing\Exception\RouteMatchingException;

class RouteDispatcher
{
    /**
     * Type matches.
     *
     * @var array
     */
    const matchTypes = [
        'i' => '[0-9]+',
        's' => '[a-zA-z]+',
        'any' => '.*',
    ];

    /** @var RouteCollection */
    protected $routes;

    /** @var string */
    protected $uri;

    /** @var string */
    protected $method;

    /** @var callable */
    protected $notFoundedHandler;

    /** @var callable */
    protected $methodNotAllowedHandler;

    /** @var callable */
    protected $foundedHandler;

    /**
     * Dispatcher constructor.
     *
     * @param RouteCollection $routes
     * @param string          $uri
     * @param                 $method
     */
    public function __construct(RouteCollection $routes, $uri, $method)
    {
        $this->routes = $routes;
        $this->uri    = $uri;
        $this->method = $method;
    }

    /**
     * Handles the routes collection and returns the response.
     *
     * @param callable $dispatchCallback If not callback was provided the dispatch foundCallback will be used.
     *
     * @return mixed
     */
    public function dispatch($dispatchCallback = null)
    {
        /** @var Route $route */
        foreach ($this->routes->getRoutes() as $route) {
            if ($this->matchMethod($route->getMethod()) !== 0) {
                return call_user_func($this->methodNotAllowedHandler);
            }

            if (($matches = $this->matchUri($route->getPath())) !== false) {
                $routeInfo = [
                    $route->getMethod(),
                    $route->getPath(),
                    $route->getHandler(),
                    $matches
                ];
                return call_user_func_array($dispatchCallback ?: $this->foundedHandler, [$routeInfo]);
            }
        }

        // If not callback was returned that's means no matching was founded for the request
        return call_user_func($this->notFoundedHandler);
    }

    public function methodNotAllowedHandler($handler)
    {
        $this->methodNotAllowedHandler = $handler;
    }

    public function foundedHandler($handler)
    {
        $this->foundedHandler = $handler;
    }

    public function notFoundedHandler($handler)
    {
        $this->notFoundedHandler = $handler;
    }

    protected function matchUri($compare)
    {
        $compare = trim($compare, '/');

        $matchTypes = [];

        if (preg_match_all('/:(\w+)/i', $compare, $matches)) {
            $matchTypes = $this->extractMatches($matches);
        }

        $subject = $compare;
        $replace = '';
        foreach ($matchTypes as $param) {
            if (!array_key_exists($param, self::matchTypes)) {
                throw new RouteMatchingException("[$param] is unknown match type.");
            }

            $regex = sprintf('/:(%s)/i', $param);

            $replace = preg_replace($regex, '('.self::matchTypes[$param].')', $subject);
            $subject = $replace;
        }

        $escape = str_replace('/', '\\/', $replace);
        $regex = "/^$escape$/i";

        if (preg_match_all($regex, trim($this->uri, '/'), $matches)) {
            return $this->extractMatches($matches);
        }

        return false;
    }

    protected function matchMethod($compare)
    {
        return strcmp($this->method, $compare);
    }

    protected function extractMatches($matches)
    {
        array_shift($matches);

        $result = [];
        foreach ($matches as $array) {
            foreach ($array as $val) {
                $result[] = $val;
            }
        }
        return $result;
    }
}