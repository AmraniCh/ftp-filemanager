<?php

namespace FTPApp\Controllers;

use FTPApp\Http\HttpRequest;

abstract class FilemanagerControllerAbstract extends Controller
{
    /**
     * FilemanagerControllerAbstract constructor retrieve the connection configuration from
     * the session and initialize the ftp adapter connection for every request.
     *
     * @param HttpRequest $request
     *
     * @throws \FTPApp\Modules\FtpAdapterException
     */
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);

        // Resume the existing session and not start a new one.
        if ($this->session()->cookieExists()) {
            $this->session()->start();
            $this->ftpAdapter()->openConnection($this->sessionStorage()->getVariable('config'));
        }
    }
}