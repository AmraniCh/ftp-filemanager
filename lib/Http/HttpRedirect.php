<?php

namespace FTPApp\Http;

/**
 * An Http redirection response.
 */
class HttpRedirect extends HttpResponse
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * HttpRedirect constructor.
     *
     * @param string $uri
     * @param int    $statusCode
     * @param array  $headers
     */
    public function __construct($uri, $statusCode = 301, $headers = [])
    {
        parent::__construct($statusCode, null, $headers);
        $this->uri = $uri;
    }

    /**
     * Makes an Http redirection to the uri using the 'Location' Http header.
     */
    public function redirect()
    {
        $this->addHeader('Location', $this->uri);
        $this->sendRawHeaders();
        $this->setResponseCode();
        exit();
    }
}