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
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->cookies = $_COOKIE;
        $this->headers = getallheaders() ?: [];
        $this->server = $_SERVER;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->server['QUERY_STRING'];
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return array_merge($this->get, $this->post);
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
    public function getHeaders()
    {
        return $this->headers;
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
}