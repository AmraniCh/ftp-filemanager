<?php

namespace FTPApp\Controllers;

use FTPApp\Http\HttpRequest;
use FTPApp\Http\JsonResponse;
use FTPApp\Modules\FtpAdapterException;

abstract class FilemanagerControllerAbstract extends Controller
{
    /**
     * FilemanagerControllerAbstract constructor retrieve the connection configuration from
     * the session and initialize the ftp adapter connection for every request, it also
     * set a custom exception handler to avoid repeating try/catch structure for every
     * controller method.
     *
     * @param HttpRequest $request
     *
     * @throws \FTPApp\Modules\FtpAdapterException
     */
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);

        // Resume the existing session and not start a new one
        if ($this->session()->cookieExists()) {
            $this->session()->start();

            $config   = $this->sessionStorage()->getVariable('config');
            $loggedIn = $this->sessionStorage()->getVariable('loggedIn');

            if (is_array($config) && is_bool($loggedIn) && $loggedIn) {
                $this->ftpAdapter()->openConnection($config);
            }
        }
    }
}