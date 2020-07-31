<?php

namespace FTPApp\Controllers\Filemanager;

use FTPApp\Controllers\Controller;
use FTPApp\Http\HttpRequest;
use FTPApp\Http\HttpResponse;
use FTPApp\Modules\FtpClientAdapter;

class FilemanagerController extends Controller
{
    /** @var FtpClientAdapter */
    protected $adapter;

    /**
     * FilemanagerController constructor.
     *
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        $this->adapter = $this->get('FtpClientAdapter');
    }

    public function getFiles()
    {
        return new HttpResponse($this->adapter->getFiles('')[0]);
    }

    public function index()
    {
        return $this->renderWithResponse('filemanager', ['homeUrl' => $this->generateUrl('home')]);
    }
}