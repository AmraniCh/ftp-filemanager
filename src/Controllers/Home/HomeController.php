<?php

namespace FTPApp\Controllers\Home;

use FTPApp\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->renderWithResponse('homepage', ['filemanagerUrl' => $this->generateUrl('filemanager')]);
    }
}