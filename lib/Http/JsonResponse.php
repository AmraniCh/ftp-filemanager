<?php

namespace FTPApp\Http;

use FTPApp\Http\Exception\HttpInvalidArgumentException;

class JsonResponse extends HttpResponse
{
    /**
     * JsonResponse constructor.
     *
     * @param mixed $content
     * @param int   $statusCode
     * @param array $headers
     */
    public function __construct($content, $statusCode = 200, $headers = [])
    {
        if (!($content = json_encode($content))) {
            throw new HttpInvalidArgumentException("Cannot parse JsonResponse content as a JSON string.");
        }

        parent::__construct($content, $statusCode, $headers);
        $this->addHeader('Content-type', 'application/json');
    }
}