<?php

namespace FTPApp\Routing;

use FTPApp\Routing\Exception\RouteInvalidArgumentException;

class Route
{
    /**
     * Define the allowed route request methods.
     * @var array $allowedMethods
     */
    protected static $allowedMethods = [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
        'HEAD',
        'OPTIONS',
        'TRACE',
        'CONNECT',
    ];

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
        $this->setMethods($methods);
        $this->setPath($path);
        $this->setHandler($handler);
        $this->setName($name);
        $this->setMatches([]);
    }

    /**
     * Handles the static calls of route methods like Route::get().
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return static Return new route instance.
     */
    public static function __callStatic($name, $arguments)
    {
        array_unshift($arguments, [strtoupper($name)]);
        return forward_static_call_array([self::class, 'instanceFactory'], $arguments);
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
        foreach ($methods as $method) {
            if (!in_array($method, self::$allowedMethods, true)) {
                throw new RouteInvalidArgumentException("$method is unknown http method");
            }
        }

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
        if (!is_callable($handler) && !is_array($handler)) {
            throw new RouteInvalidArgumentException(
                "Route handler must be either an array or a function callback, " . gettype($handler) . "giving.");
        }

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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    protected static function instanceFactory($methods, $path, $handler, $name = '')
    {
        return new static($methods, $path, $handler, $name);
    }
}