<?php

use FTPApp\AppHandler;
use FTPApp\Http\HttpRequest;
use FTPApp\Http\HttpResponse;

require __DIR__ . '/../src/bootstrap.php';

$request = new HttpRequest();
$handler = new AppHandler($request);
$response = $handler->handle();
if ($response instanceof HttpResponse) {
    $response->clearReadyHeaders()->send();
}