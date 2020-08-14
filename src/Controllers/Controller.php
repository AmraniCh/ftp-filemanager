<?php

namespace FTPApp\Controllers;

use FTPApp\DIC\DIC;
use FTPApp\Http\HttpRedirect;
use FTPApp\Http\HttpRequest;
use FTPApp\Http\HttpResponse;
use FTPApp\Modules\FtpAdapter;
use FTPApp\Session\Session;
use FTPApp\Session\SessionStorage;

abstract class Controller
{
    /** @var DIC */
    protected static $container;

    /** @var array */
    protected static $config;

    /** @var HttpRequest */
    protected $request;

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
     * @param DIC $container
     */
    public static function setContainer($container)
    {
        self::$container = $container;
    }

    /**
     * @return DIC
     */
    public static function getContainer()
    {
        return self::$container;
    }

    /**
     * @return array
     */
    public static function getConfig()
    {
        return self::$config;
    }

    /**
     * @param array $config
     */
    public static function setConfig($config)
    {
        self::$config = $config;
    }

    /**
     * @param string $name
     * @param string $definition
     *
     * @return void
     */
    public static function set($name, $definition)
    {
        self::$container->set($name, $definition);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public static function get($name)
    {
        return self::$container->get($name);
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
        if (!$this->has('Renderer')) {
            throw new \LogicException("The renderer service not registered for the base controller.");
        }

        return self::get('Renderer')->render($view, $params);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return self::$container->has($name);
    }

    /**
     * Renders a view and returns the result as an http response.
     *
     * @param string $view
     * @param array  $params
     * @param int    $statusCode
     * @param array  $headers
     *
     * @return string
     */
    public function renderWithResponse($view, $params = [], $statusCode = 200, $headers = [])
    {
        return new HttpResponse($this->render($view, $params), $statusCode, $headers);
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
        if (!$this->has('RouteUrlGenerator')) {
            throw new \LogicException("The RouteUrlGenerator service not registered for the base controller.");
        }

        return self::get('RouteUrlGenerator')->generate($name, $params);
    }

    /**
     * Makes a simple http redirection.
     *
     * @param string $uri
     * @param int    $statusCode
     * @param array  $headers
     *
     * @return HttpRedirect
     */
    public function redirect($uri, $statusCode = 301, $headers = [])
    {
        return new HttpRedirect($uri, $statusCode, $headers);
    }

    /**
     * Redirects to the giving route.
     *
     * @param string $route
     * @param int    $statusCode
     * @param array  $headers
     *
     * @return HttpRedirect
     */
    public function redirectToRoute($route, $statusCode = 301, $headers = [])
    {
        return new HttpRedirect($this->generateUrl($route), $statusCode, $headers);
    }

    /**
     * Gets the configured session service.
     *
     * @return Session
     */
    public function session()
    {
        if (!$this->has('Session')) {
            throw new \LogicException("Session service not registered for the base controller.");
        }

        return self::get('Session');
    }

    /**
     * Gets the session storage service.
     *
     * @return SessionStorage
     */
    public function sessionStorage()
    {
        if (!$this->has('Session')) {
            throw new \LogicException("SessionStorage service not available in the base controller.");
        }

        return self::get('SessionStorage');
    }

    /**
     * Gets the http request parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->request->getParameters();
    }

    /**
     * @return FtpAdapter
     */
    public function ftpAdapter()
    {
        if (!$this->has('FtpAdapter')) {
            throw new \LogicException("FtpAdapter service not registered.");
        }

        return self::get('FtpAdapter');
    }
}
