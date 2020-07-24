<?php

namespace FTPApp\Routing;

class Route
{
    /** @var array */
    protected $methods;

    /** @var string  */
    protected $path;

    /** @var array|callable */
    protected $handler;

    /** @var array */
    protected $matches;

    /**
     * Route constructor.
     *
     * @param $methods
     * @param $path
     * @param $handler
     */
    public function __construct($methods, $path, $handler)
    {
        $this->methods  = $methods;
        $this->path    = $path;
        $this->handler = $handler;
        $this->matches = [];
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array|callable
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return array
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @param array $methods
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param array|callable $handler
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param array $matches
     */
    public function setMatches($matches)
    {
        $this->matches = $matches;
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
        return new static(['GET'], $path, $handler);
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
        return new static(['POST'], $path, $handler);
    }
}