<?php

namespace FTPApp\Modules\FtpAdapter;

use FTPApp\Http\HttpResponse;

interface FtpAdapter
{
    /**
     * Opens the FTP connection using the provided configs.
     *
     * @param array $config
     *
     * @return void
     *
     * @throws FtpAdapterException
     */
    public function openConnection($config);

    /**
     * Gets a list of files in the giving directory.
     *
     * @param string $dir
     *
     * @return mixed
     *
     * @throws FtpAdapterException
     */
    public function browse($dir);

    /**
     * @param string $file
     *
     * @return bool
     *
     * @throws FtpAdapterException
     */
    public function addFile($file);

    /**
     * @param string $folder
     *
     * @return bool
     *
     * @throws FtpAdapterException
     */
    public function addFolder($folder);

    /**
     * @param string $file
     *
     * @return string
     *
     * @throws FtpAdapterException
     */
    public function getFileContent($file);

    /**
     * @param string $file
     *
     * @param string $content
     *
     * @return string
     *
     * @throws FtpAdapterException
     */
    public function updateFileContent($file, $content);

    /**
     * Removes a list of files.
     *
     * @param array $files
     *
     * @return bool
     *
     * @throws FtpAdapterException
     */
    public function remove($files);

    /**
     * Renames a file.
     *
     * @param string $file
     * @param string $newName
     *
     * @return bool
     *
     * @throws FtpAdapterException
     */
    public function rename($file, $newName);

    /**
     * Gets full directories tree.
     *
     * @return array
     *
     * @throws FtpAdapterException
     */
    public function getDirectoryTree();

    /**
     * Move a file to the giving directory.
     *
     * @param string $file
     * @param string $newPath
     *
     * @return bool
     *
     * @throws FtpAdapterException
     */
    public function move($file, $newPath);

    /**
     * Sets the giving permission on a remote file.
     *
     * @param string $file
     * @param string $permissions
     *
     * @return bool
     *
     * @throws FtpAdapterException
     */
    public function permissions($file, $permissions);

    /**
     * Starts downloading a remote file.
     *
     * @param string $file
     *
     * @return HttpResponse
     *
     * @throws FtpAdapterException
     */
    public function download($file);

    /**
     * Uploading the giving file to the server.
     *
     * @param string $filePath
     * @param string $remotePath
     * @param bool   $resume
     *
     * @return bool
     *
     * @throws FtpAdapterException
     */
    public function upload($filePath, $remotePath, $resume);
}