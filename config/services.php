<?php

use FTPApp\Modules\FtpClientAdapter;
use FTPApp\Renderer\Renderer;
use FTPApp\Routing\RouteCollection;
use FTPApp\Routing\RouteUrlGenerator;
use FTPApp\Controllers\Controller;

$services = [

    'RouteUrlGenerator' => new RouteUrlGenerator(
        new RouteCollection(
            include(dirname(__FILE__) . '/routes.php')
        )
    ),

    'Renderer' => new Renderer(dirname(__DIR__) . '/src/views'),

    'FtpClientAdapter' => new FtpClientAdapter(),
];


/**
 * Adding services to the base controller so all extended
 * controllers will haves access to this services.
 */
foreach ($services as $name => $value) {
    Controller::set($name, $value);
}