<?php

namespace FTPApp\Modules\FtpClient;

use FTPApp\Modules\FtpAdapter;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\Connection\ConnectionInterface;
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
     * FtpClientAdapter constructor.
     *
     * @param ConnectionInterface $connection
     * @param FtpConfig           $config
     * @param FtpClient           $client
     */
    public function __construct(ConnectionInterface $connection, FtpConfig $config, FtpClient $client)
    {
        $this->connection = $connection;
        $this->config     = $config;
        $this->client     = $client;
    }

    public function openConnection()
    {
        $this->connection->open();
    }

    public function setPassive($bool)
    {
        $this->config->setPassive($bool);
    }

    public function browse($dir)
    {
        return $this->client->listDirectoryDetails($dir);
    }
}
