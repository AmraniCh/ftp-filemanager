<?php

namespace FTPApp\Modules;

interface FtpAdapter
{
    /**
     * Opens the FTP connection using the provided configs.
     *
     * @param array $config
     *
     * @throws FtpAdapterException
     *
     * @return void
     */
    public function openConnection($config);

    /**
     * Sets the passive mode on/off.
     *
     * @param bool $bool
     *
     * @return mixed
     */
    public function setPassive($bool);

    /**
     * Gets a list of files in the giving directory.
     *
     * @param string $dir
     *
     * @return mixed
     */
    public function browse($dir);
}