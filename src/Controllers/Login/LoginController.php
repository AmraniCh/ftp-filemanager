<?php

namespace FTPApp\Controllers\Login;

use FTPApp\Controllers\Controller;
use FTPApp\Modules\FtpAdapterException;

class LoginController extends Controller
{
    public function index()
    {
        // Delete the session cookie
        $this->session()->deleteCookie();
        // Destroy session data
        $this->session()->destroy();

        return $this->renderWithResponse('login', ['homeUrl' => $this->generateUrl('home')]);
    }

    public function login()
    {
        try {
            $config = $this->request->getBodyParameters();

            // Try to open the a successful ftp connection
            $this->ftpAdapter()->openConnection($config);

            // Store the client connection configuration in the session
            $this->session()->start();
            $this->sessionStorage()->setVariable('config', $config);
            $this->sessionStorage()->setVariable('loggedIn', true);

        } catch (FtpAdapterException $ex) {
            return $this->renderWithResponse('/login', [
                'serverError' => $ex->getMessage(),
                'homeUrl' => $this->generateUrl('home')
            ], 500);
        }

        return $this->redirectToRoute('filemanager');
    }
}