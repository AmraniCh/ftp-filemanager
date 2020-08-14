<?php

namespace FTPApp\Controllers\Home;

use FTPApp\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->session()->start();
        return $this->renderWithResponse('homepage', ['loginUrl' => $this->generateUrl('login')]);
    }
}