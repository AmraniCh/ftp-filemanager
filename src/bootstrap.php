<?php

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

require __DIR__ . '/../vendor/autoload.php';

define('ENV', 'DEVELOPMENT');
define('ERROR_LOG_FILE', __DIR__ . '/../php-errors.log');

if (defined('ENV')) {
    // Reporting all types of errors
    error_reporting(E_ALL);

    // Enable error logging for both production and developments
    ini_set('log_errors', TRUE);

    // Create an instance of whoops object
    $whoops = new Run;

    switch (ENV) {
        case 'DEVELOPMENT':
            // Enable display errors
            ini_set('display_errors', TRUE);
            // Enable php errors concerning configuration, extensions ...
            ini_set('display_startup_errors', TRUE);
            // Reporting all types of errors
            error_reporting(E_ALL);

            // Using whoops PrettyPageHandler to show errors in the development mode
            $whoops->pushHandler(new PrettyPageHandler);
            break;

        case 'PRODUCTION':

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
                error_log($message, 3, ERROR_LOG_FILE);

                // Redirect to a custom error page
                header ('Location: http://' . $_SERVER['HTTP_HOST'] . '/ftp-filemanager/public/error.php',
                    true,
                    302
                );
                exit();
            });
            break;

        default:
            exit('Application environment is not set correctly.');
    }

    // Register this whoops instance as the error & exception handler
    $whoops->register();
}
