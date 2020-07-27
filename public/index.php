<?php

use FTPApp\AppHandler;
use FTPApp\DIC\DIC;
use FTPApp\Http\HttpRequest as Request;
use FTPApp\Http\HttpResponse as Response;

require __DIR__ . '/../config/bootstrap.php';

$request = new Request();
$container = new DIC(include(dirname(__DIR__) . '/config/services.php'));
$app = new AppHandler($request, $container);
$response = $app->handle();
if ($response instanceof Response) {
    $response->clearReadyHeaders()->send();
}