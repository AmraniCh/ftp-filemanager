<?php

namespace FTPApp\Controllers\Login;

use FTPApp\Controllers\FilemanagerControllerAbstract;
use FTPApp\Modules\FtpClientAdapter;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\Connection\FtpConnection;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\Exception\FtpClientException;
use Lazzard\FtpClient\FtpClient;

class LoginController extends FilemanagerControllerAbstract
{
    public function index()
    {
        return $this->renderWithResponse('login', ['homeUrl' => $this->generateUrl('home')]);
    }

    public function login()
    {
        try {
            $credentials  = $this->request->getBodyParameters();

            $connectionInitializer = FtpConnection::class;
            if (isset($credentials['useSsl']) && $credentials['useSsl']) {
                $connectionInitializer = FtpSSLConnection::class;
            }

            $connection = new $connectionInitializer($credentials['host'],
                $credentials['username'],
                $credentials['password'],
                $credentials['port']
            );

            $config = new FtpConfig($connection);
            $client = new FtpClient($connection);

            $this->ftpClientAdapter = new FtpClientAdapter($connection, $config, $client);
            $this->ftpClientAdapter->openConnection();

            if (isset($credentials['usePassive']) && $credentials['usePassive']) {
                $this->ftpClientAdapter->setPassive(true);
            }

            // Store the ftpClientAdapter in the session
            $this->storeAdapterInSession();

        } catch (FtpClientException $ex) {
            return $this->renderWithResponse('/login', [
                'serverError' => 'Connection to FTP server failed.',
                'homeUrl' => $this->generateUrl('home')
            ], 500);
        }

        $this->redirectToRoute('filemanager');
    }
}