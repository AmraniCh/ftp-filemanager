<?php

namespace FTPApp\Controllers;

class Homepage extends Controller
{
    public function index()
    {
        return $this->render('homepage.html');
    }
}