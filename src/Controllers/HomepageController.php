<?php

namespace FTPApp\Controllers;

use FTPApp\Http\HttpResponse;
use FTPApp\Routing\RouteCollection;
use FTPApp\Routing\RouteUrlGenerator;

class HomepageController extends Controller
{
    /**
     * @return HttpResponse
     *
     * @throws \Exception
     */
    public function index()
    {
        $generator = new RouteUrlGenerator(
            new RouteCollection(
                include(dirname(__FILE__) . '/../routes.php')
            )
        );

        return new HttpResponse($this->render('homepage', [
            'name' => 'chakir',
            'contact-url' => $generator->generate('contact')
        ]));
    }
}