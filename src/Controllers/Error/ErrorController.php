<?php

namespace FTPApp\Controllers\Error;

use FTPApp\Controllers\Controller;
use FTPApp\Http\HttpResponse;

class ErrorController extends Controller
{
    public function index($errorCode)
    {
        return new HttpResponse(
            $this->render('error', ['errorCode' => $errorCode]),
            $errorCode
        );
    }
}