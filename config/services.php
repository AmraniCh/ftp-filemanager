<?php

use FTPApp\Routing\RouteUrlGenerator;
use FTPApp\Routing\RouteCollection;
use FTPApp\Renderer\Renderer;
use FTPApp\Session\Session;
use FTPApp\Session\SessionStorage;

return [

    'RouteUrlGenerator' => new RouteUrlGenerator(
        new RouteCollection(
            include(dirname(__FILE__) . '/routes.php')
        )
    ),

    'Renderer' => new Renderer(dirname(__DIR__) . '/src/views'),

    'Session' => new Session(include(dirname(__FILE__) . '/session.php')),

    'SessionStorage' => new SessionStorage(),

];
