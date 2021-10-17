<?php

use FTPApp\ErrorHandling\ErrorHandler;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('log_errors', true);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

/**
 * ErrorHandler catch exceptions and set a custom error/exception
 * handler according to if we're in a development or production mode,
 * then a pretty page generated with whoops with a generic exception
 * (production mode) or with exception details (dev mode).
 */
$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);

$configFile = dirname(__DIR__) . '/config/app.php';
if (!file_exists($configFile) || !is_readable($configFile)) {
    $whoops->handleException(new \RuntimeException("The application config file is missing or isn't readable."));
}

$config = include($configFile);

if ($config['debug']) {
    $handler = new ErrorHandler(function ($ex) use($whoops) {
        $whoops->handleException($ex);
    });
} elseif (!$config['debug']) {
    $handler = new ErrorHandler(function ($ex) use($whoops) {
        // Build the message string
        $message = sprintf(
            "[%s] [%s] [%s] [Line : %s]\n%s\n",
            date('Y:m:d h:m:s'),
            $ex->getMessage(),
            $ex->getFile(),
            $ex->getLine(),
            $ex->getTraceAsString()
        );
        // logs the generated error info to a custom file
        error_log($message, 3, dirname(__DIR__) . '/storage/logs/'.date('Y-m-d').'.log');
        // send a friendly message to the user
        $whoops->handleException(new Exception("Oops! Something goes wrong."));
    });
}

$handler->start();
