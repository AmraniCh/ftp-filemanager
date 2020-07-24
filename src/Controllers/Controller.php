<?php


namespace FTPApp\Controllers;


use FTPApp\Http\HttpResponse;

abstract class Controller
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $uri
     * @param int    $responseCode
     *
     * @return HttpResponse
     */
    public function render($uri, $responseCode = 200)
    {
        return (new HttpResponse($this->fetch($uri), $responseCode))->clearReadyHeaders();
    }

    /**
     * @param $uri
     *
     * @return string|false
     */
    protected function fetch($uri)
    {
        return file_get_contents($uri);
    }
}