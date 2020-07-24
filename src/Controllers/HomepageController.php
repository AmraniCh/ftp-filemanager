<?php

namespace FTPApp\Controllers;

class HomepageController extends Controller
{
    public function index()
    {
        return $this->render('homepage.html');
    }
}