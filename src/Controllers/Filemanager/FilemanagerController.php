<?php

namespace FTPApp\Controllers\Filemanager;

use FTPApp\Controllers\FilemanagerControllerAbstract;
use FTPApp\Http\JsonResponse;

class FilemanagerController extends FilemanagerControllerAbstract
{
    public function index()
    {
        /**
         * Check if the session cookie exists, if doesn't
         * make a redirection to login page.
         */
        if (!$this->session()->cookieExists()) {
            return $this->redirectToRoute('login');
        }

        /**
         * If a session already exists regenerate the session ID
         * and delete the old session associated file.
         */
        $this->session()->regenerateID(true);

        return $this->renderWithResponse('filemanager', ['homeUrl' => $this->generateUrl('home')]);
    }

    public function browse()
    {
        return new JsonResponse([
            'result' => $this->ftpAdapter()->browse($this->getParameters()['path']),
        ]);
    }
}
