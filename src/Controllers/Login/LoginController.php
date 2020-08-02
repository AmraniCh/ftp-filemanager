<?php

namespace FTPApp\Controllers\Login;

use FTPApp\Controllers\Controller;
use FTPApp\Modules\FtpClientAdapter;
use FTPApp\Session\Session;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\Connection\FtpConnection;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\Exception\FtpClientException;
use Lazzard\FtpClient\FtpClient;

class LoginController extends Controller
{
    public function index()
    {
        return $this->renderWithResponse('login', ['homeUrl' => $this->generateUrl('home')]);
    }

    public function login()
    {
        try {
            $cardinals  = $this->request->getBodyParameters();

            $connectionInitializer = FtpConnection::class;
            if (isset($cardinals['useSsl']) && $cardinals['useSsl']) {
                $connectionInitializer = FtpSSLConnection::class;
            }

            $connection = new $connectionInitializer($cardinals['host'],
                $cardinals['username'],
                $cardinals['password'],
                $cardinals['port']
            );

            $config = new FtpConfig($connection);
            $client = new FtpClient($connection);

            $this->ftpClientAdapter = new FtpClientAdapter($connection, $config, $client);
            $this->ftpClientAdapter->openConnection();

            if (isset($cardinals['usePassive']) && $cardinals['usePassive']) {
                $this->ftpClientAdapter->setPassive(true);
            }

        } catch (FtpClientException $ex) {
            return $this->renderWithResponse('/login', [
                'serverError' => 'Connection to FTP server failed.',
                'homeUrl' => $this->generateUrl('home')
            ], 500);
        }

        Session::setDirectivesConfiguration([
            'name' => 'FTPAPPSESSID',
            'cookie_httponly' => true,
        ]);
        // TODO samesite=Strict for the session
        Session::start();

        $this->redirectToRoute('filemanager');
    }
}