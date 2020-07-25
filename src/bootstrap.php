<?php

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use FTPApp\Http\HttpRedirect;

require __DIR__ . '/../vendor/autoload.php';

// Define the application environment constant
define('ENV', 'PRODUCTION', false);

// Reporting all types of errors
error_reporting(E_ALL);

// Enable error logging
ini_set('log_errors', true);

// Enable display errors
ini_set('display_errors', true);

// Enable php errors concerning configuration, extensions ...
ini_set('display_startup_errors', true);

// Create an instance of whoops object
$whoops = new Run;

switch (ENV) {
    case 'DEVELOPMENT':
        // Using whoops PrettyPageHandler to show errors in the development mode
        $whoops->pushHandler(new PrettyPageHandler);
        break;

    case 'PRODUCTION':
        /**
         * Whoops already handles the errors this is just for
         * more security to make sure the errors will not be displayed
         */
        ini_set('display_errors', false);

        // Pushing a callback handler to the whoops handlers stack
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
            error_log($message, 3,  __DIR__ . '/../php-errors.log');

            // Redirect to a custom error page
            (new HttpRedirect('error.php', 301))
                ->clearReadyHeaders()
                ->redirect();
        });
        break;

    default:
        exit('Application environment is not set correctly.');
}

// Register this whoops instance as the error & exception handler
$whoops->register();
