<?php

namespace FTPApp\Http;

use FTPApp\Http\Exception\InvalidArgumentHttpException;

/**
 * Class HttpResponse represents an http response with a basic methods.
 */
class HttpResponse
{
    /** @var int */
    public $statusCode;

    /** @var mixed */
    public $content;

    /** @var array $headers */
    public $headers;

    /**
     * HttpResponse constructor.
     *
     * @param int   $statusCode
     * @param mixed $content
     * @param array $headers
     */
    public function __construct($statusCode, $content, $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->content    = $content;
        $this->headers    = $headers;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @throws InvalidArgumentHttpException
     */
    public function addHeader($name, $value)
    {
        if (array_key_exists($name, $this->headers)) {
            throw new InvalidArgumentHttpException("Cannot add Http header [$name], it already exists.");
        }

        $this->headers[$name] = $value;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @throws InvalidArgumentHttpException
     */
    public function setHeader($name, $value)
    {
        if (!array_key_exists($name, $this->headers)) {
            throw new InvalidArgumentHttpException("Http header [$name] doesn't exists to overwrite their value.");
        }

        $this->headers[$name] = $value;
    }

    /**
     * @return void
     */
    public function send()
    {
        $this->sendContent($this->content);
    }

    /**
     * @return void
     */
    public function sendJSON()
    {
        $this->sendContent(json_encode($this->content));
    }

    /**
     * @return void
     */
    public function removeXPoweredByHeader()
    {
        if (!headers_sent() && $this->hasResponseHeader('X-Powered-By')) {
            header_remove('X-Powered-By');
        }
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function removeHeader($name)
    {
        if (!array_key_exists($name, $this->getResponseHeaders())) {
            throw new InvalidArgumentHttpException("Http header [$name] doesn't exists to remove.");
        }

        header_remove($name);
    }

    /**
     * Gets all headers that's will be send with the response.
     *
     * @return array
     */
    public function getResponseHeaders()
    {
        return array_merge($this->headers, $this->getReadyHeaders());
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasResponseHeader($name)
    {
        return array_key_exists($name, $this->getResponseHeaders());
    }

    /**
     * @return void
     */
    public function cleanContent()
    {
        if (ob_get_contents()) {
            ob_clean();
        }
    }

    /**
     * Sends all Http headers if not already sent.
     *
     * @return void
     */
    protected function sendRawHeaders()
    {
        if (headers_sent() && empty($this->headers)) {
            return;
        }

        foreach ($this->headers as $name => $value) {
            header(sprintf("%s: %s", ucfirst(strtolower($name)), $value), false);
        }
    }

    /**
     * Sets the Http status code.
     */
    protected function setResponseCode()
    {
        http_response_code($this->statusCode);
    }

    /**
     * @return array
     */
    protected function getReadyHeaders()
    {
        $headers = [];

        foreach (headers_list() as $header) {
            $parts                             = explode(' ', $header);
            $headers[substr($parts[0], 0, -1)] = $parts[1];
        }

        return $headers;
    }

    protected function sendContent($content)
    {
        $this->sendRawHeaders();
        $this->setResponseCode();
        echo $content;
        exit();
    }
}