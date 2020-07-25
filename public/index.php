<?php

use FTPApp\AppHandler;
use FTPApp\Http\HttpRequest;
use FTPApp\Http\HttpResponse;

require __DIR__ . '/../src/bootstrap.php';

$request = new HttpRequest();
$handler = new AppHandler($request);
$response = $handler->handle();
if ($response instanceof HttpResponse) {
    $response->send();
}








/*
$uri = $_SERVER['REQUEST_URI'];

$uri = trim($uri, '/');

$routePath = trim('/posts/:id-:name', '/');


$params = preg_match_all('/:(\w+)/i', $routePath, $matches);
array_shift($matches);










$replace = preg_replace('/:(\w)+/i', '([\w]+)', $routePath);

var_dump($replace);

echo '<br>';

$escape = str_replace('/', '\\/', $replace);

$regex = "/^$escape$/i";

var_dump($regex);

echo '<br>';

if (preg_match_all($regex, $uri, $m)) {

    array_shift($m);

    var_dump($m);
} else {
    echo 'no matches';
}*/














/*
$request = new \FTPApp\Http\HttpRequest();
$handler = new AppHandler($request);
$response = $handler->handle();
$response->clearReadyHeaders()->send();*/