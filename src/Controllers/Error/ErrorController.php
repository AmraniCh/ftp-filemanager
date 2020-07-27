<?php

namespace FTPApp\Controllers\Error;

use FTPApp\Controllers\Controller;

class ErrorController extends Controller
{
    public function index($errorCode)
    {
        return $this->renderWithResponse('error', [ 'errorCode' => $errorCode ]);
    }
}