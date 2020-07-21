<?php

require __DIR__ . '/../src/bootstrap.php';

$response = new \FTPApp\Http\HttpResponse(202, [
    'data' => 'File was successfully created'
], [
    'X-Custom' => 'mamak'
]);
$response->removeXPoweredByHeader();
$response->cleanContent();
$response->sendJSON();