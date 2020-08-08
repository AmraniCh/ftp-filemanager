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
     * @param FtpClientException $exception
     *
     * @return string|string[]|null
     */
    public static function normalizeExceptionMessage($exception)
    {
        return preg_replace('/([\[\w\]]+)\s-\s/i', '', $exception->getMessage());
    }

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
                $this->setPassive(true);
            }
        } catch (FtpClientException $ex) {
            throw new FtpClientAdapterException(self::normalizeExceptionMessage($ex));
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
            $list = $this->client->listDirectoryDetails($dir);

            $files = [];
            foreach ($list as $file) {
                $files[] = [
                    'name'         => $file['name'],
                    'type'         => $file['type'],
                    'size'         => $file['size'],
                    'modifiedTime' => sprintf("%s %s %s", $file['day'], $file['month'], $file['time']),
                    'permissions'  => $file['chmod'],
                ];
            }

            return $files;
        } catch (FtpClientException $ex) {
            throw new FtpClientAdapterException(self::normalizeExceptionMessage($ex));
        }
    }

    public function addFile($file)
    {
        try {
            return $this->client->createFile($file);
        } catch (FtpClientException $ex) {
            throw new FtpClientAdapterException(self::normalizeExceptionMessage($ex));
        }
    }

    public function addFolder($dir)
    {
        try {
            return $this->client->createDirectory($dir);
        } catch (FtpClientException $ex) {
            throw new FtpClientAdapterException(self::normalizeExceptionMessage($ex));
        }
    }

    public function getFileContent($file)
    {
        try {
            return $this->client->getFileContent($file);
        } catch (FtpClientException $ex) {
            throw new FtpClientAdapterException(self::normalizeExceptionMessage($ex));
        }
    }
}
