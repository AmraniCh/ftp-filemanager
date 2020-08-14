<?php

namespace FTPApp\Controllers\Filemanager;

use FTPApp\Controllers\FilemanagerControllerAbstract;
use FTPApp\Http\JsonResponse;
use FTPApp\Modules\FtpAdapterException;

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

        return $this->renderWithResponse('filemanager', [
            'homeUrl'   => $this->generateUrl('home'),
            'logoutUrl' => $this->generateUrl('login'),
        ]);
    }

    public function browse()
    {
        try {
            return new JsonResponse([
                'result' => $this->ftpAdapter()->browse($this->getParameters()['path']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function addFile()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            return new JsonResponse([
                'result' => $this->ftpAdapter()->addFile($params['path'] . $params['name']),
            ], 201);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function addFolder()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            return new JsonResponse([
                'result' => $this->ftpAdapter()->addFolder($params['path'] . $params['name']),
            ], 201);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function getFileContent()
    {
        try {
            return new JsonResponse([
                'result' => $this->ftpAdapter()->getFileContent($this->request->getParameters()['file']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function updateFileContent()
    {
        try {
            return new JsonResponse([
                'result' => $this->ftpAdapter()->updateFileContent(
                    $this->request->getJSONBodyParameters()['file'],
                    $this->request->getJSONBodyParameters()['content']
                ),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function remove()
    {
        try {
            return new JsonResponse([
                'result' => $this->ftpAdapter()->remove($this->request->getJSONBodyParameters()['files']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function rename()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            $path   = $params['path'];
            return new JsonResponse([
                'result' => $this->ftpAdapter()->rename($path . $params['file'], $path . $params['newName']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function getDirectoryTree()
    {
        try {
            return new JsonResponse([
                'result' => $this->ftpAdapter()->getDirectoryTree(),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function move()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            return new JsonResponse([
                'result' => $this->ftpAdapter()->move($params['path'] . $params['file'], $params['newPath']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function permissions()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            return new JsonResponse([
                'result' => $this->ftpAdapter()->permissions($params['path'] . $params['file'], $params['permissions']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function download()
    {
        try {
            return $this->ftpAdapter()->download($this->getParameters()['file']);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function upload()
    {
        try {
            $file = $this->request->getFiles()['file'];
            return new JsonResponse([
                'result' => $this->ftpAdapter()->upload(
                    $file['tmp_name'],
                    $this->getParameters()['path'] . $file['name']
                ),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }
}
