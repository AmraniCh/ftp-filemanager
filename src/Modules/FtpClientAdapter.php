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
}