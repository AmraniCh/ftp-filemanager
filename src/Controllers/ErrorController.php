<?php

namespace FTPApp\Controllers;

use FTPApp\Http\HttpResponse;

class ErrorController extends Controller
{

    /**
     * ErrorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $url = urlencode('error.php');
        (new HttpResponse(file_get_contents($url, false), 404))
            ->clearReadyHeaders()
            ->send();
    }
}