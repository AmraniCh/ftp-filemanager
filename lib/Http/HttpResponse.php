<?php

namespace FTPApp\Http;

use FTPApp\Http\Exception\HttpInvalidArgumentException;

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

    /** @var array */
    public $cookies;

    /**
     * HttpResponse constructor.
     *
     * @param mixed $content
     * @param int   $statusCode
     * @param array $headers
     */
    public function __construct($content = null, $statusCode = 200, $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->content    = $content;
        $this->headers    = $headers;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     * @throws HttpInvalidArgumentException
     *
     */
    public function addHeader($name, $value)
    {
        if (array_key_exists($name, $this->headers)) {
            throw new HttpInvalidArgumentException("Cannot add Http header [$name], it already exists.");
        }

        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     * @throws HttpInvalidArgumentException
     *
     */
    public function setHeader($name, $value)
    {
        if (!array_key_exists($name, $this->headers)) {
            throw new HttpInvalidArgumentException("Http header [$name] doesn't exists to overwrite their value.");
        }

        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function send()
    {
        $this->sendContent($this->content);

        return $this;
    }

    /**
     * @return $this
     */
    public function sendJSON()
    {
        $this->sendContent(json_encode($this->content));

        return $this;
    }

    /**
     * @return $this
     */
    public function removeXPoweredByHeader()
    {
        if (!headers_sent() && $this->hasHeader('X-Powered-By')) {
            header_remove('X-Powered-By');
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeHeader($name)
    {
        if (!array_key_exists($name, $this->getResponseHeaders())) {
            throw new HttpInvalidArgumentException("Http header [$name] doesn't exists to remove.");
        }

        header_remove($name);

        return $this;
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
    public function hasHeader($name)
    {
        return array_key_exists($name, $this->getResponseHeaders());
    }

    /**
     * @return $this
     */
    public function cleanContent()
    {
        if (ob_get_contents()) {
            ob_clean();
        }

        return $this;
    }

    /**
     * Clears all ready headers.
     *
     * @return $this
     */
    public function clearReadyHeaders()
    {
        if (headers_sent() || empty(headers_list())) {
            return $this;
        }

        foreach ($this->getReadyHeaders() as $name => $value) {
            header_remove($name);
        }

        return $this;
    }

    /**
     * Clear all headers that's not sent yet.
     */
    public function clearAllHeaders()
    {
        $this->headers = [];
    }

    /**
     * @param array $cookies
     *
     * @return $this
     */
    public function withCookies($cookies)
    {
        if (!is_array($cookies)) {
            throw new HttpInvalidArgumentException(
                sprintf("An array must be passed to %s, %s given.",
                    __METHOD__,
                    gettype($cookies)
                ));
        }

        foreach ($cookies as $cookie) {
            if ($cookie instanceof HttpCookie) {
                $this->cookies[] = $cookie;
            }
        }

        return $this;
    }

    protected function sendCookies()
    {
        if (empty($this->cookies)) {
            return;
        }

        /** @var HttpCookie $cookie */
        foreach ($this->cookies as $cookie) {
            setcookie(
                $cookie->getName(),
                $cookie->getValue(),
                $cookie->getExpire(),
                $cookie->getPath(),
                $cookie->getDomain(),
                $cookie->isSecure(),
                $cookie->isHttpOnly()
            );
            // Same site
            if ($cookie->getSameSite() !== HttpCookie::SAMESITE_NONE) {
                header(
                    sprintf(
                        'Set-cookie: %s=%s;samesite=%s',
                        $cookie->getName(),
                        $cookie->getValue(),
                        $cookie->getSameSite()
                    ),
                    false, // Disable replacing
                    null
                );
            }
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

        // TODO Should send the content-type header ??
        /*
        if ($this->content) {
            $this->addHeader('Content-type', 'text/plain');
        }*/

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
            $parts = explode(' ', $header);
            $headers[substr($parts[0], 0, -1)] = $parts[1];
        }

        return $headers;
    }

    /**
     * @param mixed $content
     */
    protected function sendContent($content)
    {
        $this->sendRawHeaders();
        $this->sendCookies();
        $this->setResponseCode();
        echo $content;
        exit();
    }
}