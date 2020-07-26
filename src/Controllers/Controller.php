<?php

namespace FTPApp\Controllers;

use FTPApp\Http\HttpRequest;

abstract class Controller
{
    /** @var HttpRequest */
    protected $request;

    /** @var array */
    protected static $services;

    /**
     * Controller constructor.
     *
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $name
     * @param string $definition
     *
     * @return void
     */
    public static function set($name, $definition)
    {
        self::$services[$name] = $definition;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public static function get($name)
    {
        return self::$services[$name];
    }

    /**
     * Renders a view.
     *
     * @param string $view
     * @param array  $params
     *
     * @return string
     */
    public function render($view, $params = [])
    {
        return self::get('Renderer')->render($view, $params);
    }

    /**
     * Generates a dynamic url from a route path.
     *
     * @param string $name
     * @param array  $params
     *
     * @return string
     */
    public function generateUrl($name, $params = [])
    {
        return self::get('RouteUrlGenerator')->generate($name, $params);
    }
}