<?php

use FTPApp\Controllers\Controller;
use FTPApp\Routing\RouteCollection;
use FTPApp\Routing\RouteUrlGenerator;

$services = [
    'url-generator' => new RouteUrlGenerator(
        new RouteCollection(
            include(dirname(__FILE__) . '/routes.php')
        )
    )
];

// Adding services to the base controller
foreach ($services as $name => $value) {
    Controller::addService($name, $value);
}