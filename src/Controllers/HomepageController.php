<?php

namespace FTPApp\Controllers;

use FTPApp\Http\HttpResponse;

class HomepageController extends Controller
{
    /**
     * @return HttpResponse
     *
     * @throws \Exception
     */
    public function index()
    {
        return new HttpResponse($this->render('homepage', ['name' => 'chakir']));
    }
}