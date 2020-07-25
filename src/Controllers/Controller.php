<?php

namespace FTPApp\Controllers;

use FTPApp\Http\HttpRequest;
use FTPApp\Templating\Template;
use FTPApp\Templating\TemplateException;

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
     * Renders the template and returns the gathered content as a string.
     *
     * @param string $template
     * @param array  $params
     *
     * @return string|false
     *
     * @throws TemplateException
     */
    public function render($template, $params = [])
    {
        $template = new Template($template, $params);
        return $template->render();
    }

    public static function getServices()
    {
        return array_keys(self::$services);
    }

    public static function addService($name, $definition)
    {
        self::$services[$name] = $definition;
    }

    public static function getService($name)
    {
        return self::$services[$name];
    }
}