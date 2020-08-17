<?php

use FTPApp\ErrorHandling\ErrorHandler;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('log_errors', true);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

$configFile = dirname(__DIR__) . '/config/app.php';

if (!file_exists($configFile)) {
    throw new RuntimeException("Application config file was missing.");
}

$config = include($configFile);

if ($config['debug']) {
    $handler = new ErrorHandler(function (\Exception $exx) {
        echo "<h1>" . get_class($exx) . "</h1>";
        echo "<h3>" . $exx->getMessage() . "</h3>";
        echo "<p>File : " . $exx->getFile() . "</p>";
        echo "<p>Line : " . $exx->getLine() . "</p>";
        echo "<pre>Trace : " . $exx->getTraceAsString() . "</pre>";
    });
}

if (!$config['debug']) {
    $handler = new ErrorHandler(function (\Exception $ex) {
        // Build the message string
        $message = sprintf(
            "[%s] [%s] [%s] [Line : %s]\n%s\n",
            date('Y:m:d h:m:s'),
            $ex->getMessage(),
            $ex->getFile(),
            $ex->getLine(),
            $ex->getTraceAsString()
        );

        // Logging error to a log file
        error_log($message, 3, dirname(__DIR__) . '/storage/logs/'.date('Y-m-d').'.log');

        // Send a friendly message to the user.
        echo "<h3 style='color:#333;letter-spacing: 2px;'>Oops! Something goes wrong.</h3>";
        exit();
    });
}

$handler->start();
