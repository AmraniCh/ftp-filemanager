<?php

namespace FTPApp\Controllers\Home;

use FTPApp\Controllers\Controller;
use FTPApp\Http\HttpResponse;

class HomeController extends Controller
{
    public function index()
    {
        return new HttpResponse($this->render('homepage'));
    }
}