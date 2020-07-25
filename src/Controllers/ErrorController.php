<?php

namespace FTPApp\Controllers;

use FTPApp\Http\HttpResponse;

class ErrorController extends Controller
{
    public function index()
    {
        return new HttpResponse($this->render('error', ['ErrorCode' => 404]), 404);
    }
}