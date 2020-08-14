<?php

use http\Exception\RuntimeException;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('log_errors', true);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

$configFile = dirname(__DIR__).'/config/app.php';

if (!file_exists($configFile)) {
    throw new RuntimeException("Application config file was missing.");
}

$config = include($configFile);
$whoops = new Run;

if ($config['debug']) {
    // Using whoops PrettyPageHandler to show errors in debug mode
    $whoops->pushHandler(new PrettyPageHandler);
}

if (!$config['debug']) {
    // Pushing a custom callback handler to the whoops handlers stack
    $whoops->pushHandler(function (Exception $e) {
        // Build a message string
        $message = sprintf(
            "[%s] [%s] [%s] [Line : %s]\n",
            date('Y:m:d h:m:s'),
            $e->getFile(),
            $e->getMessage(),
            $e->getLine()
        );

        // Logging the error info to the predefined logs file
        error_log($message, 3, dirname(__DIR__).'/storage/logs/errors.log');
    });
}

// Register this whoops instance as the error & exception handler
$whoops->register();
