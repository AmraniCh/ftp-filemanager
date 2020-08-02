<?php


namespace FTPApp\Modules;


class FtpClientAdapter
{
    public function getFiles($directory)
    {
        return [
            'file1',
            'file2'
        ];
    }

    public function openConnection()
    {
        $this->connection->open();
    }

    public function setPassive($bool)
    {
        $this->config->setPassive($bool);
    }
}