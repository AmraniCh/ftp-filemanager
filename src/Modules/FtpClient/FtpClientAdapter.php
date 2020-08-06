<?php

namespace FTPApp\Modules\FtpClient;

use FTPApp\Modules\FtpAdapter;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\Connection\ConnectionInterface;
use Lazzard\FtpClient\Connection\FtpConnection;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\Exception\FtpClientException;
use Lazzard\FtpClient\FtpClient;

class FtpClientAdapter implements FtpAdapter
{
    /** @var ConnectionInterface */
    public $connection;

    /** @var FtpConfig */
    public $config;

    /** @var FtpClient */
    public $client;

    /**
     * @inheritDoc
     */
    public function openConnection($config)
    {
        try {
            $connectionInitializer = FtpConnection::class;
            if (isset($config['useSsl']) && $config['useSsl']) {
                $connectionInitializer = FtpSSLConnection::class;
            }

            $connection = new $connectionInitializer(
                $config['host'],
                $config['username'],
                $config['password'],
                $config['port']
            );

            $connection->open();

            $this->connection = $connection;
            $this->config     = new FtpConfig($connection);
            $this->client     = new FtpClient($connection);

            if (isset($config['usePassive']) && $config['usePassive']) {
                $this->setPassive($config['usePassive']);
                $this->setPassive(true);
            }

        } catch (FtpClientException $ex) {
            throw new FtpClientAdapterException("Connection failed to remote server.");
        }
    }

    /**
     * @inheritDoc
     */
    public function setPassive($bool)
    {
        $this->config->setPassive($bool);
    }

    /**
     * @inheritDoc
     */
    public function browse($dir)
    {
        try {
            return $this->client->listDirectoryDetails($dir);
        } catch (FtpClientException $ex) {
            throw new FtpClientAdapterException("Cannot get directory files list.");
        }
    }
}
