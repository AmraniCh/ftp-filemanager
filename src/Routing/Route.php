<?php

namespace FTPApp\Routing;

class Route
{
    /** @var array */
    protected $methods;

    /** @var string */
    protected $path;

    /** @var array|callable */
    protected $handler;

    /** @var array */
    protected $matches;

    /** @var string */
    protected $name;

    /**
     * Route constructor.
     *
     * @param array    $methods
     * @param string   $path
     * @param callable $handler
     * @param string   $name
     */
    public function __construct($methods, $path, $handler, $name = '')
    {
        $this->methods = $methods;
        $this->path    = $path;
        $this->handler = $handler;
        $this->name    = $name;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @param string   $path
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public static function get($path, $handler, $name = '')
    {
        return new static(['GET'], $path, $handler, $name);
    }

    /**
     * Creates a new route instance for a 'POST' request.
     *
     * @param string   $path
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public static function post($path, $handler, $name = '')
    {
        return new static(['POST'], $path, $handler, $name);
    }
}