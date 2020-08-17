<?php

use FTPApp\AppHandler;
use FTPApp\DIC\DIC;
use FTPApp\Http\HttpRequest as Request;
use FTPApp\Http\HttpResponse as Response;
use FTPApp\Routing\RouteCollection;
use FTPApp\Routing\RouteDispatcher;

require __DIR__ . '/../config/bootstrap.php';

$request    = new Request();
$dispatcher = new RouteDispatcher(
    new RouteCollection(include(dirname(__DIR__) . '/config/routes.php')),
    $request->getQueryString(),
    $request->getMethod()
);
$container  = new DIC(include(dirname(__DIR__) . '/config/services.php'));

$app = new AppHandler($request, $dispatcher, $container);
$app->init();

$response = $app->handle();
if ($response instanceof Response) {
    $response->removeXPoweredByHeader()->send();
}