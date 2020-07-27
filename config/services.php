<?php

use FTPApp\Routing\RouteUrlGenerator;
use FTPApp\Routing\RouteCollection;
use FTPApp\Renderer\Renderer;
use FTPApp\Modules\FtpClientAdapter;

return [

    'RouteUrlGenerator' => new RouteUrlGenerator(
        new RouteCollection(
            include(dirname(__FILE__) . '/routes.php')
        )
    ),

    'Renderer' => new Renderer(dirname(__DIR__) . '/src/views'),

    'FtpClientAdapter' => new FtpClientAdapter(),
];
