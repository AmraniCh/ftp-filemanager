<?php

namespace FTPApp\Controllers;

class Homepage extends Controller
{
    public function index()
    {
        $this->render('homepage.html');
    }
}