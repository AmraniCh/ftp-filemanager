<?php

use FTPApp\AppHandler;
use FTPApp\Http\HttpResponse;
use FTPApp\Http\HttpRequest;

require __DIR__ . '/../src/bootstrap.php';

// Handle the request
$request = new HttpRequest();
$handler = new AppHandler($request);
$response = $handler->handle();
if ($response instanceof HttpResponse) {
    $response->clearReadyHeaders()->send();
}