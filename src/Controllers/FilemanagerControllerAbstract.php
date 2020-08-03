<?php

namespace FTPApp\Controllers;

use FTPApp\Http\HttpRequest;
use FTPApp\Modules\FtpClientAdapter;

/**
 * FilemanagerControllerAbstract retrieves the ftpClientAdapter from the session and preparing it
 * for the sub controllers that's need an ftpClientAdapter.
 */
abstract class FilemanagerControllerAbstract extends Controller
{
    /** @var FtpClientAdapter */
    protected $ftpClientAdapter;

    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        $this->retrieveAdapterFromSession();
        $this->prepareAdapter();
    }

    /**
     * Stores the ftpClientAdapter as a session variable.
     * 
     * @return void
     */
    protected function storeAdapterInSession()
    {
        $this->session()->start();
        $this->sessionStorage()->setVariable('ftpClientAdapter', $this->ftpClientAdapter);
    }

    /**
     * @param FtpClientAdapter $ftpClientAdapter
     */
    private function setFtpClientAdapter($ftpClientAdapter)
    {
        if ($ftpClientAdapter instanceof FtpClientAdapter) {
            $this->ftpClientAdapter = $ftpClientAdapter;
        }
    }

    /**
     * Retrieves the FtpClientAdapter from the session.
     * 
     * @return void
     */
    private function retrieveAdapterFromSession()
    {
        $this->session()->start();
        if ($adapter = $this->sessionStorage()->getVariable('ftpClientAdapter')) {
            $this->setFtpClientAdapter($adapter);
        }
    }

    /**
     * @return void
     */
    private function prepareAdapter()
    {
        if ($this->ftpClientAdapter instanceof FtpClientAdapter) {
            $this->ftpClientAdapter->openConnection();
        }
    }
}