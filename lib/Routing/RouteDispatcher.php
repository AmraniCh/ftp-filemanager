<?php

namespace FTPApp\Routing;

use FTPApp\Routing\Exception\RouteMatchingException;

class RouteDispatcher
{
    /**
     * Define the match types.
     *
     * @var array
     */
    const MATCH_TYPES = [
        'i'       => '[0-9]+',
        's'       => '[a-zA-z]+',
        'encoded' => '[^;,/?:@&=+$]+',
        'any'     => '.*',
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
     * RouteDispatcher constructor.
     *
     * @param RouteCollection $routes
     * @param string          $uri
     * @param string          $method
     */
    public function __construct(RouteCollection $routes, $uri, $method)
    {
        $this->routes = $routes;
        $this->uri    = $this->getRequestUri($uri);
        $this->method = $method;
    }

    /**
     * Handles the routes collection and returns the result of the defined handler.
     *
     * @param callable $dispatchCallback If not callback was provided the dispatch foundCallback will be used.
     *
     * @return mixed
     */
    public function dispatch($dispatchCallback = null)
    {
        $routeInfo = [];
        /** @var Route $route */
        foreach ($this->routes->getRoutes() as $route) {
            if (($matches = $this->matchUri($route->getPath()))) {
                $route->setMatches($matches);
                $routeInfo = [
                    $route->getMethods(),
                    $route->getPath(),
                    $route->getHandler(),
                    $route->getMatches(),
                ];

                if ($this->isMethodNotAllowed($route)) {
                    return call_user_func_array($this->methodNotAllowedHandler, [$routeInfo]);
                }

                if ($this->matchMethod($route->getMethods())) {
                    return call_user_func_array($dispatchCallback ?: $this->foundedHandler, [$routeInfo]);
                }
            }
        }

        // If no callback was returned that's means no matching was founded for the request uri
        return call_user_func_array($this->notFoundedHandler, [$routeInfo]);
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

    protected function matchUri($routeUri)
    {
        // If the route uri matches the requested uri then returns the match
        if (strcmp($this->uri, $routeUri) === 0) {
            return [$routeUri];
        }

        // Remove slashes from the route uri => avoiding troubles after
        $routeUri = trim($routeUri, '/');

        // Get the match types from the routes
        if (preg_match_all('/:(\w+)/i', $routeUri, $matches)) {
            $matchTypes = $this->extractMatches($matches);

            // Replace each match type in the route uri with the appropriate match type regex
            $subject = $routeUri;

            $replace = '';
            foreach ($matchTypes as $param) {
                // If the match type is not registered throws an exception
                if (!array_key_exists($param, self::MATCH_TYPES)) {
                    throw new RouteMatchingException("[$param] is unknown match type.");
                }
                $regex   = sprintf('/:(%s)/i', $param);
                $replace = preg_replace($regex, '(' . self::MATCH_TYPES[$param] . ')', $subject);
                $subject = $replace;
            }

            // Escape the special chars
            $replace = $this->escapedSpecialChars($replace);

            // Build a new regex
            $regex = "/^$replace$/i";

            // Matches the request uri using the regex '$regex'
            if (preg_match_all($regex, trim($this->uri, '/'), $matches)) {
                return $this->extractMatches($matches);
            }
        }

        return false;
    }

    protected function matchMethod($routeMethods)
    {
        return in_array($this->method, $routeMethods, true);
    }

    protected function escapedSpecialChars($uri)
    {
        $specialChars = ['/', '?'];

        $subject = $uri;
        $replace = '';
        foreach ($specialChars as $char) {
            $replace = str_replace($char, '\\' . $char, $subject);
            $subject = $replace;
        }

        return $replace;
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

    protected function isMethodNotAllowed($route)
    {
        $methods = [];

        // Loop through the routes collection
        /** @var Route $r */
        foreach ($this->routes->getRoutes() as $r) {
            if ($route->getPath() !== $r->getPath()) {
                continue;
            }

            foreach ($r->getMethods() as $method) {
                $methods[] = $method;
            }
        }

        return !in_array($this->method, $methods);
    }

    /**
     * Gets the actual requested uri.
     *
     * @param string $uri
     *
     * @return string
     */
    protected function getRequestUri($uri)
    {
        if ($uri == '') {
            return '/';
        } else {
            /**
             * Fix the [QSA] flag which replace the question
             * mark for the query sting with an '&' char.
             */
            return '/' . preg_replace('/&/', '?', $uri, 1);
        }
    }
}