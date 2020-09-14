<?php

namespace FTPApp\Http;

/**
 * An Http redirection response.
 */
class HttpRedirect extends HttpResponse
{
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
        $this->addHeader('Location', $uri);
    }
}