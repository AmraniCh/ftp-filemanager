<?php

use FTPApp\Routing\RouteCollection;
use FTPApp\Routing\RouteUrlGenerator;

return [
    'url-generator' => new RouteUrlGenerator(
        new RouteCollection(
            include(dirname(__FILE__) . '/routes.php')
        )
    )
];