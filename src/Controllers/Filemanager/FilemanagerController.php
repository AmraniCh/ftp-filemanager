<?php


namespace FTPApp\Controllers\Filemanager;


use FTPApp\Controllers\Controller;
use FTPApp\Http\HttpResponse;
use FTPApp\Modules\FtpClientAdapter;

class FilemanagerController extends Controller
{
    /** @var FtpClientAdapter */
    protected $adapter;

    /**
     * FilemanagerController constructor.
     */
    public function __construct()
    {
        $this->adapter = $this->get('FtpClientAdapter');
    }

    public function getFiles()
    {
        return new HttpResponse($this->adapter->getFiles('/')[0]);
    }
}