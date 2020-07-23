<?php

namespace FTPApp\Routing;

class Route
{
    protected $method;
    protected $path;
    protected $handler;

    /**
     * Route constructor.
     *
     * @param $method
     * @param $path
     * @param $handler
     */
    public function __construct($method, $path, $handler)
    {
        $this->method  = $method;
        $this->path    = $path;
        $this->handler = $handler;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Creates a new route instance for a 'GET' request.
     *
     * @param string $path
     * @param callable $handler
     *
     * @return Route
     */
    public static function get($path, $handler)
    {
        return new static('GET', $path, $handler);
    }

    /**
     * Creates a new route instance for a 'POST' request.
     *
     * @param string $path
     * @param callable $handler
     *
     * @return Route
     */
    public static function post($path, $handler)
    {
        return new static('POST', $path, $handler);
    }
}