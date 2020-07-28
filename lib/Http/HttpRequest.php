<?php

namespace FTPApp\Http;

/**
 * A very basic class represents an http request.
 *
 * The request simply created from the PHP super globals vars that's holds some http request
 * information like $_GET and $_POST...
 */
class HttpRequest
{
    /** @var array */
    protected $get;

    /** @var array */
    protected $post;

    /** @var array */
    protected $files;

    /** @var array */
    protected $cookies;

    /** @var array */
    protected $headers;

    /** @var array */
    protected $server;

    /**
     * HttpRequest constructor.
     */
    public function __construct()
    {
        $this->get     = $_GET;
        $this->post    = $_POST;
        $this->files   = $_FILES;
        $this->cookies = $_COOKIE;
        $this->headers = getallheaders() ?: [];
        $this->server  = $_SERVER;
    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function getBodyParameters()
    {
        return $this->post;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * @return string|null
     */
    public function getQueryString()
    {
        if (isset($this->server['QUERY_STRING'])) {
            return $this->server['QUERY_STRING'];
        }

        return null;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return array_merge($this->get, $this->post);
    }

    /**
     * @param  string $name
     *
     * @return string|false
     */
    public function getParameter($name)
    {
        if (array_key_exists($name, $this->getParameters())) {
            return $this->getParameters()[$name];
        }

        return false;
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param string $header
     *
     * @return bool
     */
    public function hasHeader($header)
    {
        return array_key_exists(ucfirst(strtolower($header)), $this->headers);
    }

    /**
     * @return bool
     */
    public function isAjaxRequest()
    {
        if (in_array('X_REQUESTED_WITH', $this->headers, false)) {
            return $this->headers['X_REQUESTED_WITH'] === 'XMLHttpRequest';
        }

        return false;
    }

    public function getUri()
    {
        return $this->server['REQUEST_URI'];
    }


}
