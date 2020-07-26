<?php

use FTPApp\AppHandler;
use FTPApp\Http\HttpRequest;
use FTPApp\Http\HttpResponse;

require __DIR__ . '/../config/bootstrap.php';
require __DIR__ . '/../config/services.php';

// Handle the request
$request = new HttpRequest();
$handler = new AppHandler($request);
$response = $handler->handle();
if ($response instanceof HttpResponse) {
    $response->clearReadyHeaders()->send();
}