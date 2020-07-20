<?php


require __DIR__ . '/../src/bootstrap.php';

$request = new \FTPApp\Http\HttpRequest;

var_dump($request->getMethod());
var_dump($request->getQueryString());
var_dump($request->getParameters());
var_dump($request->hasHeader('host'));
var_dump($request->isAjaxRequest());